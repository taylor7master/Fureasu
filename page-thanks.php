<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="page-thanks">
    <div class="container">
        <div class="thanks-message">
            <p class="thanks-lead">お問い合わせいただき<br class="sp-only">ありがとうございます。</p>
            <p class="thanks-note">営業日以内に担当者よりご連絡いたします。</p>
            <p class="thanks-watermark" aria-hidden="true">Thank you</p>
        </div>
        <div class="page-back">
            <a href="<?php echo esc_url( HOME ); ?>" class="link-btn link-btn--submit">
                <span>TOPへ戻る</span>
            </a>
        </div>
    </div>
</section>
<?php
get_template_part( 'template-parts/banner' );

get_footer();
