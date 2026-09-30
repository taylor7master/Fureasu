<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $cat  = fureasu_primary_category();
        $prev = get_previous_post();
        $next = get_next_post();
?>
<section class="page-blog-detail">
    <div class="container">
        <div class="blog-detail-wrapper">
            <ul class="blog-meta">
                <?php if ( $cat ) : ?>
                <li>
                    <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="cat"><span><?php echo esc_html( $cat->name ); ?></span></a>
                </li>
                <?php endif; ?>
                <li>
                    <time class="date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
                </li>
            </ul>
            <h1 class="blog-title"><?php the_title(); ?></h1>
            <?php if (has_post_thumbnail()) : ?>
            <figure class="blog-thumb scrt-cover">
                <?php the_post_thumbnail('full'); ?>
            </figure>
            <?php endif; ?>
            <article class="blog-detail"><?php the_content(); ?></article>
            <?php if ( $prev || $next ) : ?>
            <nav class="blog-nav">
                <?php if ( $prev ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="blog-nav-prev">
                    <span class="label">前の記事へ</span>
                    <span class="title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                </a>
                <?php endif; ?>
                <?php if ( $next ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="blog-nav-next">
                    <span class="label">次の記事へ</span>
                    <span class="title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
                </a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>

            <div class="blog-action">
                <a href="<?php echo esc_url( HOME . 'column/' ); ?>" class="action-btn action-btn--secondary">
                    <span>コラム一覧へ戻る</span>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
    endwhile;
endif;

get_template_part( 'template-parts/banner' );
get_footer();
