<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $slug = get_post_field( 'post_name', get_post() );
?>
<section class="page-index" data-title="<?php echo esc_attr( strtoupper( $slug ) ); ?>">
    <div class="container">
        <div class="page-index-title">
            <h1 class="jp"><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<section class="page-breadcrumbs">
    <div class="container">
        <ol class="breadcrumbs-list">
            <li><a href="<?php echo esc_url( HOME ); ?>" class="link">ホーム</a></li>
            <li><span class="text"><?php the_title(); ?></span></li>
        </ol>
    </div>
</section>

<section class="page-privacy">
    <div class="container">
        <div class="privacy-body">
            <?php the_content(); ?>
        </div>
        <div class="page-back">
            <a href="<?php echo esc_url( HOME ); ?>" class="page-btn page-btn--back">
                <svg width="6" height="12" viewBox="0 0 6 12" fill="none">
                    <path d="M5.6682 12C5.57604 12 5.47465 11.9489 5.36406 11.8468C4.79263 11.2511 3.92627 10.3404 2.76498 9.11489C1.60369 7.88936 0.737327 6.97872 0.165899 6.38298C0.0552996 6.24681 0 6.11915 0 6C0 5.86383 0.0552996 5.73617 0.165899 5.61702C0.718894 5.02128 1.57604 4.11064 2.73733 2.88511C3.91705 1.65957 4.79263 0.748936 5.36406 0.153191C5.47465 0.0510633 5.57604 0 5.6682 0C5.70507 0 5.76037 0.0170216 5.8341 0.0510642C5.9447 0.102128 6 0.187233 6 0.306382C6 0.374468 5.98157 0.442554 5.9447 0.510639L2.95853 6L5.9447 11.566C5.98157 11.634 6 11.6936 6 11.7447C6 11.8298 5.9447 11.8979 5.8341 11.9489C5.76037 11.983 5.70507 12 5.6682 12Z" fill="#46322C"/>
                </svg>
                <span>TOPへ戻る</span>
            </a>
        </div>
    </div>
</section>
<?php
    endwhile;
endif;

get_template_part( 'template-parts/banner' );

get_footer();
