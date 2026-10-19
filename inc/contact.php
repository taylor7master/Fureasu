<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Production nginx returns 403 for pretty /wp-json/contact-form-7/... URLs.
 * Query-string REST (/?rest_route=/contact-form-7/...) returns 200.
 * CF7 builds requests as api.root + "contact-form-7/v1/...", so point
 * api.root at /?rest_route=/ before the CF7 script runs.
 */
add_action( 'wpcf7_enqueue_scripts', 'fureasu_cf7_fix_api_root', 20 );

function fureasu_cf7_fix_api_root() {
    wp_add_inline_script(
        'contact-form-7',
        sprintf(
            'if (window.wpcf7 && wpcf7.api) { wpcf7.api.root = %s; }',
            wp_json_encode( home_url( '/?rest_route=/' ) )
        ),
        'before'
    );
}

add_filter( 'wpcf7_validate_email', 'fureasu_cf7_confirm_email', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'fureasu_cf7_confirm_email', 20, 2 );

function fureasu_cf7_confirm_email( $result, $tag ) {
    if ( ! is_object( $tag ) || $tag->name !== 'your-email-confirm' ) {
        return $result;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return $result;
    }

    $posted  = $submission->get_posted_data();
    $email   = isset( $posted['your-email'] ) ? (string) $posted['your-email'] : '';
    $confirm = isset( $posted['your-email-confirm'] ) ? (string) $posted['your-email-confirm'] : '';

    if ( $email !== '' && $confirm !== '' && $email !== $confirm ) {
        $result->invalidate( $tag, '確認用メールアドレスが一致しません。' );
    }

    return $result;
}

add_filter( 'wpcf7_validate_text', 'fureasu_cf7_validate_text', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'fureasu_cf7_validate_text', 20, 2 );

function fureasu_cf7_posted_value( $posted, $name ) {
    if ( ! isset( $posted[ $name ] ) ) {
        return '';
    }

    $value = $posted[ $name ];
    if ( is_array( $value ) ) {
        $value = reset( $value );
    }

    return trim( (string) $value );
}

function fureasu_cf7_validate_text( $result, $tag ) {
    if ( ! is_object( $tag ) ) {
        return $result;
    }

    $submission = WPCF7_Submission::get_instance();
    if ( ! $submission ) {
        return $result;
    }

    $posted = $submission->get_posted_data();

    if ( 'your-company' === $tag->name ) {
        $business = fureasu_cf7_posted_value( $posted, 'your-business' );
        $company  = fureasu_cf7_posted_value( $posted, 'your-company' );
        if ( in_array( $business, array( '個人事業主', '法人' ), true ) && '' === $company ) {
            $result->invalidate( $tag, '会社名を入力してください。' );
        }
        return $result;
    }

    if ( in_array( $tag->name, array( 'your-tel1', 'your-tel2', 'your-tel3' ), true ) ) {
        $value = fureasu_cf7_posted_value( $posted, $tag->name );
        if ( '' !== $value && ! preg_match( '/^[0-9]+$/', $value ) ) {
            $result->invalidate( $tag, '電話番号は半角数字で入力してください。' );
            return $result;
        }

        $parts = array(
            fureasu_cf7_posted_value( $posted, 'your-tel1' ),
            fureasu_cf7_posted_value( $posted, 'your-tel2' ),
            fureasu_cf7_posted_value( $posted, 'your-tel3' ),
        );
        $digits = preg_replace( '/\D+/', '', implode( '', $parts ) );
        $length = strlen( $digits );

        // 12桁以上は空欄の有無に関係なくエラーにする
        if ( $length > 11 ) {
            $result->invalidate( $tag, '電話番号の桁数が正しくありません。' );
            return $result;
        }

        // 必須未入力は CF7 本体に任せる
        if ( in_array( '', $parts, true ) ) {
            return $result;
        }

        if ( $length < 10 ) {
            $result->invalidate( $tag, '電話番号の桁数が足りません。' );
        }
    }

    return $result;
}

add_filter( 'wpcf7_autop_or_not', 'fureasu_cf7_autop_for_mail', 20, 2 );

function fureasu_cf7_autop_for_mail( $autop, $options ) {
    if ( is_array( $options ) && isset( $options['for'] ) && 'mail' === $options['for'] ) {
        return true;
    }
    return $autop;
}

add_action( 'wp_head', 'fureasu_cf7_company_css' );

function fureasu_cf7_company_css() {
    if ( ! is_page( 'contact' ) ) {
        return;
    }
    echo '<style>.contact-detail-section .contact-form .form-inputs > li.company-field-row.is-hidden{display:none}'
        . '.contact-form .tel-field .wpcf7-row .wpcf7-not-valid-tip{display:none}'
        . '.contact-form .tel-field .tel-error-tip:empty{display:none}</style>';
}

add_action( 'wp_footer', 'fureasu_cf7_company_toggle' );

function fureasu_cf7_company_toggle() {
    if ( ! is_page( 'contact' ) ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('.wpcf7 form');
        if (!form) return;
        var telRow = form.querySelector('.tel-field .wpcf7-row');
        if (telRow) {
            var telTip = document.createElement('span');
            telTip.className = 'wpcf7-not-valid-tip tel-error-tip';
            telTip.setAttribute('aria-live', 'polite');
            telRow.insertAdjacentElement('afterend', telTip);
            var syncTelTip = function () {
                var first = telRow.querySelector('.wpcf7-not-valid-tip');
                var text = first ? first.textContent : '';
                if (telTip.textContent !== text) telTip.textContent = text;
            };
            new MutationObserver(syncTelTip).observe(telRow, { childList: true, subtree: true });
            syncTelTip();
        }

        var row = form.querySelector('.company-field-row');
        if (!row) return;
        var company = form.querySelector('[name="your-company"]');
        function sync() {
            var selected = form.querySelector('input[name="your-business"]:checked');
            var needs = selected && (selected.value === '個人事業主' || selected.value === '法人');
            row.classList.toggle('is-hidden', !needs);
            if (!needs && company) company.value = '';
        }
        form.querySelectorAll('input[name="your-business"]').forEach(function (radio) {
            radio.addEventListener('change', sync);
        });
        sync();
    });
    </script>
    <?php
}

add_action( 'wp_footer', 'fureasu_cf7_thanks_redirect' );

function fureasu_cf7_thanks_redirect() {
    if ( ! is_page( 'contact' ) ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('wpcf7mailsent', function () {
        window.location.href = <?php echo wp_json_encode( home_url( '/thanks/' ) ); ?>;
    });
    </script>
    <?php
}
