<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$paged       = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$current_cat = is_category() ? get_queried_object() : null;
$base        = [
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
];

if ( $current_cat && isset( $current_cat->term_id ) ) {
    $base['cat'] = (int) $current_cat->term_id;
}
if ( is_search() ) {
    $base['s'] = get_search_query();
}

$pickup_query = new WP_Query( array_merge( $base, [
    'posts_per_page' => 1,
] ) );
$exclude = [];
if ( ! empty( $pickup_query->posts ) ) {
    $exclude[] = (int) $pickup_query->posts[0]->ID;
}

$grid_query = new WP_Query( array_merge( $base, [
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post__not_in'   => $exclude,
] ) );

$categories = get_categories( [
    'hide_empty' => true,
] );
$column_url = home_url( '/column/' );
?>
<section class="blog-list-section">
    <div class="container">
        <div class="section-title">
            <h2 class="en">COLUMN</h2>
            <p class="jp">コラム サポート</p>
        </div>
        <?php if ( is_search() ) : ?>
        <p class="section-desc">「<?php echo esc_html( get_search_query() ); ?>」の検索結果</p>
        <?php endif; ?>

        <?php if ( $paged === 1 && $pickup_query->have_posts() ) : ?>
        <div class="section-pickup">
            <?php while ( $pickup_query->have_posts() ) : $pickup_query->the_post(); ?>
                <?php get_template_part( 'template-parts/column-card', null, [ 'pickup' => true ] ); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <div class="section-header">
            <ul class="voice-indexs">
                <li>
                    <a href="<?php echo esc_url( $column_url ); ?>" class="index-link<?php echo $current_cat ? '' : ' active'; ?>">
                        <span>全て</span>
                    </a>
                </li>
                <?php if ( $categories ) : ?>
                    <?php foreach ( $categories as $category ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="index-link<?php echo ( $current_cat && (int) $current_cat->term_id === (int) $category->term_id ) ? ' active' : ''; ?>">
                            <span><?php echo esc_html( $category->name ); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="section-content">
            <?php if ( $grid_query->have_posts() ) : ?>
            <ul class="blog-grid">
                <?php while ( $grid_query->have_posts() ) : $grid_query->the_post(); ?>
                <li>
                    <?php get_template_part( 'template-parts/column-card' ); ?>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php fureasu_pagination( $grid_query ); ?>
            <?php wp_reset_postdata(); ?>
            <?php elseif ( $paged === 1 && $pickup_query->post_count ) : ?>
            <?php else : ?>
            <p class="section-desc">記事が見つかりません。</p>
            <?php endif; ?>
        </div>
    </div>
</section>
