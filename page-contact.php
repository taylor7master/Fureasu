<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<section class="contact-firstview">
    <div class="container">
        <div class="section-title">
            <h2 class="en">CONTACT</h2>
            <p class="jp">資料請求・お問い合わせ</p>
        </div>
    </div>
</section>

<section class="contact-detail-section">
    <div class="container">
        <div class="content-wrapper">
            <div class="section-lead">
                <h2>資料請求・お問い合わせはこちら</h2>
                <p>下記フォームに記入してお問い合わせボタンを押してください</p>
            </div>
            <div class="section-effect">
                <h4 class="effect-label">＼　資料の中身のイメージ　／</h4>
                <figure class="effect-image">
                    <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/contact/contact-ef.png" alt="資料の中身のイメージ">
                </figure>
            </div>
            <?php echo do_shortcode( '[contact-form-7 id="7781846" title="コンタクトフォーム"]' ); ?>
        </div>
    </div>
</section>

<?php get_template_part( 'template-parts/banner' ); ?>

<?php get_footer(); ?>
