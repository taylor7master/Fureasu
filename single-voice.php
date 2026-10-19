<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $data = fureasu_get_voice_data();
        $nums = [ 'Q１', 'Q２', 'Q３', 'Q４', 'Q５', 'Q６' ];
?>
<section class="voice-intro-section">
    <div class="container">
        <div class="section-wrapper">
            <div class="section-side">
                <figure class="thumb scrt-cover">
                    <img src="<?php echo esc_url( fureasu_voice_image_url( get_the_ID(), $data ) ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $data['lead_html'] ) ); ?>" loading="lazy">
                </figure>
                <div class="profile">
                    <?php if ( $data['position'] !== '' ) : ?>
                    <p class="pos"><?php echo fureasu_kses_inline( $data['position'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( $data['name'] !== '' ) : ?>
                    <p class="name"><?php echo esc_html( $data['name'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="section-body">
                <?php if ( ! empty( $data['tags'] ) ) : ?>
                <ul class="meta">
                    <?php foreach ( $data['tags'] as $tag ) : ?>
                    <li><span class="tag"><?php echo esc_html( $tag ); ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <h2 class="lead"><?php echo fureasu_kses_inline( $data['lead_html'] ); ?></h2>
                <?php if ( $data['desc_html'] !== '' ) : ?>
                <p class="desc"><?php echo fureasu_kses_inline( $data['desc_html'] ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if ( ! empty( $data['faqs'] ) ) : ?>
<section class="voice-faq-section">
    <div class="container">
        <div class="section-content">
            <ul class="faq-list">
                <?php foreach ( $data['faqs'] as $index => $faq ) : ?>
                <li>
                    <div class="faq-item<?php echo ! empty( $faq['reverse'] ) ? ' reverse' : ''; ?>">
                        <div class="faq-q">
                            <span class="num"><?php echo esc_html( $faq['num'] !== '' ? $faq['num'] : ( $nums[ $index ] ?? ( 'Q' . ( $index + 1 ) ) ) ); ?></span>
                            <h4 class="label"><?php echo fureasu_kses_inline( $faq['q'] ); ?></h4>
                        </div>
                        <div class="faq-a">
                            <?php if ( ! empty( $faq['image'] ) ) : ?>
                            <figure class="thumb scrt-cover">
                                <img src="<?php echo esc_url( fureasu_theme_image( $faq['image'] ) ); ?>" alt="<?php echo esc_attr( $faq['image_alt'] !== '' ? $faq['image_alt'] : wp_strip_all_tags( $faq['q'] ) ); ?>" loading="lazy">
                            </figure>
                            <?php endif; ?>
                            <?php if ( ! empty( $faq['lead'] ) ) : ?>
                            <p class="lead"><?php echo fureasu_kses_inline( $faq['lead'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $faq['desc'] ) ) : ?>
                            <p class="desc"><?php echo fureasu_kses_inline( $faq['desc'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php if ( $data['bottom_lead'] !== '' || $data['bottom_desc'] !== '' ) : ?>
            <div class="faq-bottom">
                <?php if ( $data['bottom_lead'] !== '' ) : ?>
                <h4 class="lead"><?php echo esc_html( $data['bottom_lead'] ); ?></h4>
                <?php endif; ?>
                <?php if ( $data['bottom_desc'] !== '' ) : ?>
                <p class="desc"><?php echo fureasu_kses_inline( $data['bottom_desc'] ); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php
        $voice_label = static function ( $id ) {
            $d = fureasu_get_voice_data( $id );
            return $d['name'] !== '' ? $d['name'] : get_the_title( $id );
        };
        $prev = get_previous_post();
        $next = get_next_post();
        ?>  
        <nav class="voice-nav" aria-label="オーナーの声のナビゲーション">
            <?php if ( $prev ) : ?>
            <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="voice-nav-prev">
                <span class="label">前のオーナーの声へ</span>
                <span class="title"><?php echo fureasu_voice_name_html( $voice_label( $prev->ID ) ); ?></span>
            </a>
            <?php endif; ?>
            <?php if ( $next ) : ?>
            <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="voice-nav-next">
                <span class="label">次のオーナーの声へ</span>
                <span class="title"><?php echo fureasu_voice_name_html( $voice_label( $next->ID ) ); ?></span>
            </a>
            <?php endif; ?>
        </nav>
        <div class="voice-action">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'voice' ) ); ?>" class="action-btn action-btn--secondary">
                <span>一覧に戻る</span>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$related = new WP_Query( [
    'post_type'      => 'voice',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'post__not_in'   => [ get_the_ID() ],
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );
if ( $related->have_posts() ) :
?>
<section class="voice-related-section">
    <div class="container">
        <div class="section-title">
            <h2 class="en">VOICE</h2>
            <p class="jp">他のオーナーの声</p>
        </div>
        <div class="section-content">
            <ul class="voice-grid">
                <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                <li>
                    <?php get_template_part( 'template-parts/voice-card', null, [ 'variant' => 'list' ] ); ?>
                </li>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
    endwhile;
endif;

get_template_part( 'template-parts/banner' );
get_footer();
