<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$pickup = ! empty( $args['pickup'] );
$cat    = fureasu_primary_category();
$image  = fureasu_post_image_url();
$excerpt = fureasu_trim_text( get_the_excerpt() ? get_the_excerpt() : get_the_content(), 70 );
?>
<?php if ( $pickup ) : ?>
<div class="pickup-block">
    <a href="<?php the_permalink(); ?>" class="link">
        <figure class="thumb scrt-cover">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
        </figure>
        <?php if ( $cat ) : ?>
        <span class="cat"><?php echo esc_html( $cat->name ); ?></span>
        <?php endif; ?>
    </a>
    <div class="content">
        <time class="date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
        <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="desc"><?php echo esc_html( $excerpt ); ?></div>
        <div class="action">
            <a href="<?php the_permalink(); ?>" class="link-btn link-btn--secondary">
                <span>記事を読む</span>
            </a>
        </div>
    </div>
</div>
<?php else : ?>
<article class="blog-card">
    <a href="<?php the_permalink(); ?>" class="link">
        <figure class="thumb scrt-cover">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
        </figure>
        <?php if ( $cat ) : ?>
        <span class="cat"><?php echo esc_html( $cat->name ); ?></span>
        <?php endif; ?>
    </a>
    <div class="content">
        <time class="date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
        <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="desc"><?php echo esc_html( $excerpt ); ?></div>
    </div>
</article>
<?php endif; ?>
