<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fureasu_kses_inline( $html ) {
    return wp_kses( (string) $html, [
        'br'   => [ 'class' => true ],
        'em'   => [],
        'span' => [ 'class' => true ],
    ] );
}

function fureasu_theme_image( $relative, $fallback = 'voice01.png' ) {
    $relative = ltrim( (string) $relative, '/' );
    if ( $relative === '' ) {
        $relative = $fallback;
    }
    if ( preg_match( '#^https?://#', $relative ) ) {
        return $relative;
    }
    return T_DIRE_URI . '/assets/image/' . $relative;
}

function fureasu_voice_defaults() {
    return [
        'position'    => '',
        'name'        => '',
        'tags'        => [],
        'lead_html'   => '',
        'desc_html'   => '',
        'image'       => '',
        'year'        => '',
        'sales'       => '',
        'excerpt'     => '',
        'faqs'        => [],
        'bottom_lead' => '',
        'bottom_desc' => '',
    ];
}

function fureasu_get_voice_data( $post_id = null ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $data    = get_post_meta( $post_id, '_voice_data', true );
    if ( ! is_array( $data ) ) {
        $data = [];
    }
    $data = array_merge( fureasu_voice_defaults(), $data );
    if ( $data['lead_html'] === '' ) {
        $data['lead_html'] = get_the_title( $post_id );
    }
    if ( $data['excerpt'] === '' ) {
        $data['excerpt'] = wp_strip_all_tags( $data['desc_html'] );
    }
    if ( has_excerpt( $post_id ) ) {
        $data['excerpt'] = get_the_excerpt( $post_id );
    }
    return $data;
}

function fureasu_voice_image_url( $post_id, $data = null ) {
    if ( has_post_thumbnail( $post_id ) ) {
        $url = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( $url ) {
            return $url;
        }
    }
    if ( ! is_array( $data ) ) {
        $data = fureasu_get_voice_data( $post_id );
    }
    return fureasu_theme_image( $data['image'] );
}

function fureasu_trim_text( $text, $length = 80 ) {
    $text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $text ) ) );
    if ( mb_strlen( $text ) <= $length ) {
        return $text;
    }
    return mb_substr( $text, 0, $length ) . '…';
}

function fureasu_post_image_url( $post_id = null ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    if ( has_post_thumbnail( $post_id ) ) {
        $url = get_the_post_thumbnail_url( $post_id, 'large' );
        if ( $url ) {
            return $url;
        }
    }
    $caught = catch_that_image( $post_id );
    if ( $caught && strpos( $caught, 'noimage' ) === false ) {
        return $caught;
    }
    return T_DIRE_URI . '/assets/image/blog01.jpg';
}

function fureasu_primary_category( $post_id = null ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $categories = get_the_category( $post_id );
    if ( empty( $categories ) || is_wp_error( $categories ) ) {
        return null;
    }
    return $categories[0];
}

function fureasu_pagination( $query, $add_args = [] ) {
    if ( ! $query instanceof WP_Query || (int) $query->max_num_pages < 2 ) {
        return;
    }

    $paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
    $links = paginate_links( [
        'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'format'    => '',
        'current'   => $paged,
        'total'     => (int) $query->max_num_pages,
        'type'      => 'array',
        'prev_text' => '前のページ',
        'next_text' => '次のページ',
        'mid_size'  => 2,
        'add_args'  => $add_args,
    ] );

    if ( empty( $links ) ) {
        return;
    }

    echo '<div class="wp-pagenavi" role="navigation">';
    foreach ( $links as $link ) {
        $link = str_replace( 'page-numbers current', 'current', $link );
        $link = str_replace( 'class="prev page-numbers"', 'class="prevpostslink" rel="prev" aria-label="前のページ"', $link );
        $link = str_replace( 'class="next page-numbers"', 'class="nextpostslink" rel="next" aria-label="次のページ"', $link );
        $link = str_replace( 'page-numbers dots', 'extend', $link );
        $link = str_replace( 'page-numbers', 'page larger', $link );
        echo $link;
    }
    echo '</div>';
}
