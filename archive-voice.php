<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$type  = '';
if ( is_tax( 'voice_type' ) ) {
    $term = get_queried_object();
    $type = ( $term && isset( $term->slug ) ) ? $term->slug : '';
} elseif ( isset( $_GET['voice_type'] ) ) {
    $type = sanitize_title( wp_unslash( $_GET['voice_type'] ) );
}
$args  = [
    'post_type'      => 'voice',
    'post_status'    => 'publish',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];
if ( $type !== '' ) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'voice_type',
            'field'    => 'slug',
            'terms'    => $type,
        ],
    ];
}
$voice_query = new WP_Query( $args );
$archive_url = get_post_type_archive_link( 'voice' );
$filters = [
    ''      => '全て',
    'north' => '北日本',
    'east'  => '東日本',
    'west'  => '西日本',
];
?>
<section class="voice-firstview">
    <div class="firstview-wrapper">
        <div class="container">
            <div class="section-title">
                <h2 class="en">VOICE</h2>
                <p class="jp">加盟オーナーの声</p>
            </div>
            <div class="section-desc">同じ道を選んだ、仲間の声。<br>脱サラ・既存事業者・法人 ―<br>さまざまな背景のオーナーが活躍しています。 </div>
        </div>
    </div>
    <picture class="firstview-effect">
        <source srcset="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/voice/firstview-ef.png" media="(min-width: 768px)">
        <source srcset="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/voice/firstview-ef-sp.png" media="(max-width: 767px)">
        <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/voice/firstview-ef.png" alt="加盟オーナーの声" loading="lazy">
    </picture>
</section>

<section class="voice-list-section">
    <div class="container">
        <div class="section-header">
            <ul class="voice-indexs">
                <?php foreach ( $filters as $slug => $label ) : ?>
                <li>
                    <a href="<?php echo esc_url( $slug === '' ? $archive_url : add_query_arg( 'voice_type', $slug, $archive_url ) ); ?>" class="index-link<?php echo $type === $slug ? ' active' : ''; ?>">
                        <span><?php echo esc_html( $label ); ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="section-content">
            <?php if ( $voice_query->have_posts() ) : ?>
            <ul class="voice-grid">
                <?php while ( $voice_query->have_posts() ) : $voice_query->the_post(); ?>
                <li>
                    <?php get_template_part( 'template-parts/voice-card', null, [ 'variant' => 'list' ] ); ?>
                </li>
                <?php endwhile; ?>
            </ul>
            <?php fureasu_pagination( $voice_query, $type !== '' ? [ 'voice_type' => $type ] : [] ); ?>
            <?php wp_reset_postdata(); ?>
            <?php else : ?>
            <p class="section-desc">オーナーの声はまだありません。</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_template_part( 'template-parts/banner' ); ?>
<?php get_footer(); ?>
