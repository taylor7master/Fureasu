<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<section class="page-404" data-title="404">
    <div class="container">
        <div class="page-404-inner">
            <div class="page-404-title">
                <p class="sub">ERROR</p>
                <h1 class="title">NOT FOUND</h1>
                <p class="lead">ページが見つかりませんでした</p>
            </div>
            <div class="page-404-content">
                <p class="page-404-text">申し訳ありません。<br class="sp-only">指定されたページにアクセスできませんでした。<br>アドレスが変更されているか、<br class="sp-only">ページが削除されている可能性があります。<br>お手数ですが、TOPページもしくは上部メニューから目的のページをお探しください。</p>
            </div>
            <div class="page-404-action">
                <a href="<?php echo esc_url( HOME ); ?>" class="link-btn link-btn--submit">
                    <span>TOPへ戻る</span>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
get_template_part( 'template-parts/banner' );
get_footer();
