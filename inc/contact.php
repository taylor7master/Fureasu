<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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
