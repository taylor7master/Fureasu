<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'FUREASU_SITE_NAME', 'フレアス フランチャイズ加盟店募集サイト' );
define( 'FUREASU_SITE_DESC', '訪問鍼灸マッサージのフランチャイズ加盟店募集サイト｜株式会社フレアス。未経験・無資格からでも開業できます。開業準備から運営まで万全のサポート体制で、オーナー様の独立・起業を支援します。無料説明会・資料請求受付中。' );

remove_action( 'wp_head', 'rel_canonical' );

add_filter( 'option_blogname', 'fureasu_front_blogname' );

function fureasu_front_blogname( $name ) {
    return is_admin() ? $name : FUREASU_SITE_NAME;
}

function fureasu_page_descriptions() {
    return array(
        'about'   => 'フレアスグループの想いと代表メッセージ、一緒に事業を築く仲間に求めることをご紹介します。訪問鍼灸マッサージのフランチャイズ加盟店募集サイト｜株式会社フレアス。',
        'support' => 'フレアスの開業サポート体制、募集要項、開業までの流れをご紹介します。未経験・無資格からでも開業できる訪問鍼灸マッサージのフランチャイズ｜株式会社フレアス。',
        'model'   => '訪問鍼灸マッサージの収益の考え方、ストック型ビジネスの仕組みと収益のロジックをご紹介します。フランチャイズ加盟店募集｜株式会社フレアス。',
        'contact' => 'フレアスのフランチャイズに関する資料請求・お問い合わせはこちらから。訪問鍼灸マッサージのフランチャイズ加盟店募集サイト｜株式会社フレアス。',
        'faq'     => 'フレアスのフランチャイズ加盟に関するよくあるご質問をまとめています。訪問鍼灸マッサージのフランチャイズ加盟店募集サイト｜株式会社フレアス。',
    );
}

function fureasu_doc_title() {
    $site = FUREASU_SITE_NAME;

    if ( is_front_page() || is_home() ) {
        return $site;
    }

    $paged = max( 1, (int) get_query_var( 'paged' ) );
    $title = '';

    if ( is_post_type_archive( 'voice' ) || is_tax( 'voice_type' ) ) {
        $title = '加盟オーナーの声';
        if ( is_tax( 'voice_type' ) ) {
            $title = single_term_title( '', false ) . '｜' . $title;
        }
    } elseif ( is_singular( 'voice' ) ) {
        $data  = function_exists( 'fureasu_get_voice_data' ) ? fureasu_get_voice_data( get_queried_object_id() ) : array();
        $name  = isset( $data['name'] ) ? trim( (string) $data['name'] ) : '';
        $title = ( $name !== '' ? $name : get_the_title( get_queried_object_id() ) ) . '｜加盟オーナーの声';
    } elseif ( is_singular() ) {
        $title = get_the_title( get_queried_object_id() );
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $title = single_term_title( '', false ) . '｜コラム';
    } elseif ( is_search() ) {
        $title = '「' . get_search_query() . '」の検索結果';
    } elseif ( is_404() ) {
        $title = 'ページが見つかりません';
    } elseif ( is_archive() ) {
        $title = wp_strip_all_tags( get_the_archive_title() );
    }

    if ( $paged > 1 ) {
        $title .= '（' . $paged . 'ページ目）';
    }

    return $title !== '' ? $title . '｜' . $site : $site;
}

function fureasu_meta_description() {
    if ( is_front_page() || is_home() ) {
        return FUREASU_SITE_DESC;
    }

    if ( is_post_type_archive( 'voice' ) || is_tax( 'voice_type' ) ) {
        return '独立・起業・既存事業者・法人、さまざまな背景からフレアスに加盟したオーナーの声をご紹介します。訪問鍼灸マッサージのフランチャイズ加盟店募集サイト｜株式会社フレアス。';
    }

    if ( is_singular( 'voice' ) ) {
        $data = function_exists( 'fureasu_get_voice_data' ) ? fureasu_get_voice_data( get_queried_object_id() ) : array();
        $text = trim( wp_strip_all_tags( ( $data['lead_html'] ?? '' ) . ' ' . ( $data['desc_html'] ?? '' ) ) );
        if ( $text !== '' ) {
            return wp_html_excerpt( preg_replace( '/\s+/u', ' ', $text ), 110, '…' );
        }
    }

    if ( is_page() ) {
        $slug  = get_post_field( 'post_name', get_queried_object_id() );
        $pages = fureasu_page_descriptions();
        if ( isset( $pages[ $slug ] ) ) {
            return $pages[ $slug ];
        }
    }

    if ( is_singular( 'post' ) ) {
        $post = get_queried_object();
        $text = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
        $text = trim( preg_replace( '/\s+/u', ' ', $text ) );
        if ( $text !== '' ) {
            return wp_html_excerpt( $text, 110, '…' );
        }
    }

    return FUREASU_SITE_DESC;
}

function fureasu_canonical_url() {
    if ( is_404() || is_search() ) {
        return '';
    }

    if ( is_front_page() || is_home() ) {
        return home_url( '/' );
    }

    if ( is_post_type_archive( 'voice' ) ) {
        $paged = max( 1, (int) get_query_var( 'paged' ) );
        $base  = get_post_type_archive_link( 'voice' );
        return $paged > 1 ? trailingslashit( $base ) . user_trailingslashit( 'page/' . $paged, 'paged' ) : $base;
    }

    if ( is_singular() ) {
        return wp_get_canonical_url( get_queried_object_id() );
    }

    return '';
}

function fureasu_head_meta() {
    $title     = fureasu_doc_title();
    $desc      = fureasu_meta_description();
    $canonical = fureasu_canonical_url();
    $og_url    = $canonical !== '' ? $canonical : home_url( add_query_arg( array() ) );
    $og_type   = ( is_front_page() || is_home() ) ? 'website' : ( is_singular() ? 'article' : 'website' );
    $og_image  = T_DIRE_URI . '/assets/image/OGP.jpg';

    if ( is_singular() && has_post_thumbnail( get_queried_object_id() ) ) {
        $thumb = get_the_post_thumbnail_url( get_queried_object_id(), 'large' );
        if ( $thumb ) {
            $og_image = $thumb;
        }
    }
    ?>
    <title><?php echo esc_html( $title ); ?></title>
    <meta name="description" content="<?php echo esc_attr( $desc ); ?>" />
    <meta name="keywords" content="フランチャイズ,加盟店募集,訪問鍼灸マッサージ,開業,独立,起業,フレアス" />
<?php if ( $canonical !== '' ) : ?>
    <link rel="canonical" href="<?php echo esc_url( $canonical ); ?>" />
<?php endif; ?>
    <meta property="og:title" content="<?php echo esc_attr( $title ); ?>" />
    <meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>" />
    <meta property="og:url" content="<?php echo esc_url( $og_url ); ?>" />
    <meta property="og:image" content="<?php echo esc_url( $og_image ); ?>" />
    <meta property="og:site_name" content="<?php echo esc_attr( FUREASU_SITE_NAME ); ?>" />
    <meta property="og:description" content="<?php echo esc_attr( $desc ); ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <?php
}
