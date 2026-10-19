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
<?php if ( is_page( 'thanks' ) ) : ?>
    <meta name="robots" content="noindex, nofollow" />
<?php endif; ?>
    <?php
}

/**
 * HTTPS and /author/ redirects stay in PHP on purpose.
 * fc.fureasu.jp is served by nginx, which never reads .htaccess.
 * On Apache, the same rules can run before PHP. Put them in the
 * document root, outside the WordPress block, and only on a vhost
 * whose site root is / (not a subdirectory):
 *
 * RewriteEngine On
 * RewriteCond %{HTTPS} !=on
 * RewriteCond %{HTTP:X-Forwarded-Proto} !https [NC]
 * RewriteCond %{HTTP_HOST} (^|\.)fureasu\.jp$ [NC]
 * RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
 * RewriteCond %{QUERY_STRING} (^|&)author=[^&]+ [NC]
 * RewriteRule ^ /? [L,R=301]
 * RewriteRule ^author/ / [L,R=301]
 */
add_action( 'template_redirect', 'fureasu_force_https', 0 );

function fureasu_force_https() {
    if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
        return;
    }
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return;
    }
    if ( is_ssl() ) {
        return;
    }
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && strtolower( wp_unslash( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) ) === 'https' ) {
        return;
    }

    $host = isset( $_SERVER['HTTP_HOST'] ) ? wp_unslash( $_SERVER['HTTP_HOST'] ) : '';
    $uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
    if ( ! is_string( $host ) || ! preg_match( '/^[A-Za-z0-9.-]+(?::\d+)?$/', $host ) ) {
        return;
    }
    if ( ! is_string( $uri ) || strpos( $uri, '/' ) !== 0 || preg_match( '/[\r\n]/', $uri ) ) {
        return;
    }

    $name = strtolower( preg_replace( '/:\d+$/', '', $host ) );
    if ( ! preg_match( '/(^|\.)fureasu\.jp$/', $name ) ) {
        return;
    }

    wp_redirect( 'https://' . $host . $uri, 301 );
    exit;
}

add_action( 'init', 'fureasu_block_author_query', 1 );

function fureasu_block_author_query() {
    if ( is_admin() ) {
        return;
    }
    if ( isset( $_GET['author'] ) && $_GET['author'] !== '' ) {
        wp_safe_redirect( home_url( '/' ), 301 );
        exit;
    }
}

add_action( 'template_redirect', 'fureasu_block_author_archive' );

function fureasu_block_author_archive() {
    if ( is_author() ) {
        wp_safe_redirect( home_url( '/' ), 301 );
        exit;
    }
}

add_filter( 'wp_sitemaps_add_provider', 'fureasu_remove_user_sitemap', 10, 2 );

function fureasu_remove_user_sitemap( $provider, $name ) {
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}

add_action( 'send_headers', 'fureasu_security_headers' );

function fureasu_security_headers() {
    if ( is_admin() ) {
        return;
    }
    header( 'X-Content-Type-Options: nosniff' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    header( 'X-Frame-Options: SAMEORIGIN' );
}

add_filter( 'wp_sitemaps_posts_query_args', 'fureasu_exclude_thanks_from_sitemap', 10, 2 );

function fureasu_exclude_thanks_from_sitemap( $args, $post_type ) {
    if ( 'page' !== $post_type ) {
        return $args;
    }
    $thanks = get_page_by_path( 'thanks' );
    if ( ! $thanks ) {
        return $args;
    }
    $args['post__not_in']   = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
    $args['post__not_in'][] = (int) $thanks->ID;
    return $args;
}

add_filter( 'rest_pre_dispatch', 'fureasu_hide_rest_users', 10, 3 );

function fureasu_hide_rest_users( $result, $server, $request ) {
    if ( current_user_can( 'list_users' ) ) {
        return $result;
    }
    $route = $request->get_route();
    if ( is_string( $route ) && 0 === strpos( $route, '/wp/v2/users' ) ) {
        return new WP_Error(
            'rest_forbidden',
            'この情報は公開していません。',
            array( 'status' => 401 )
        );
    }
    return $result;
}
