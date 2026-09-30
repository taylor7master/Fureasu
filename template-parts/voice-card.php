<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$post_id = get_the_ID();
$data    = fureasu_get_voice_data( $post_id );
$variant = ( isset( $args['variant'] ) && $args['variant'] === 'top' ) ? 'top' : 'list';
$terms   = get_the_terms( $post_id, 'voice_type' );
$label   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$image   = fureasu_voice_image_url( $post_id, $data );
$alt     = $data['name'] !== '' ? $data['name'] : get_the_title( $post_id );
?>
<article class="swiper-slide voice-card">
    <figure class="voice-image scrt-cover">
        <?php if ( $label !== '' ) : ?>
        <figcaption><?php echo esc_html( $label ); ?></figcaption>
        <?php endif; ?>
        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
    </figure>
    <div class="voice-body">
        <div class="inner">
            <?php if ( ! empty( $data['tags'] ) ) : ?>
            <ol class="meta">
                <?php foreach ( $data['tags'] as $tag ) : ?>
                <li><span class="tag"><?php echo esc_html( $tag ); ?></span></li>
                <?php endforeach; ?>
            </ol>
            <?php endif; ?>
            <h3 class="lead"><?php the_title(); ?></h3>
            <?php if ( $data['year'] !== '' ) : ?>
            <p class="year">開業年数：<?php echo esc_html( $data['year'] ); ?></p>
            <?php endif; ?>
            <?php if ( $variant === 'list' && $data['sales'] !== '' ) : ?>
            <p class="price">売上：<?php echo esc_html( $data['sales'] ); ?></p>
            <?php endif; ?>
            <?php if ( $variant === 'list' && $data['excerpt'] !== '' ) : ?>
            <p class="desc"><?php echo esc_html( fureasu_trim_text( $data['excerpt'] ) ); ?></p>
            <?php endif; ?>
        </div>
        <div class="action">
            <a href="<?php the_permalink(); ?>" class="action-btn action-btn--detail">
                <span>詳細を見る</span>
            </a>
        </div>
    </div>
</article>
