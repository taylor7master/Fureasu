<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// サイト情報
define( 'HOME', home_url( '/' ) );
define( 'TITLE', get_option( 'blogname' ) );

// 状態
define( 'IS_ADMIN', is_admin() );
define( 'IS_LOGIN', is_user_logged_in() );
define( 'IS_CUSTOMIZER', is_customize_preview() );

// テーマディレクトリパス
define( 'T_DIRE', get_template_directory() );
define( 'S_DIRE', get_stylesheet_directory() );
define( 'T_DIRE_URI', get_template_directory_uri() );
define( 'S_DIRE_URI', get_stylesheet_directory_uri() );

define( 'THEME_NOTE', 'fureasu' );

add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('wpcf7_validate_configuration', '__return_false');

error_reporting(0);

// 固定ページとMW WP Formでビジュアルモードを使用しない
function stop_rich_editor($editor) {
    global $typenow;
    global $post;
    if(in_array($typenow, array('page', 'mw-wp-form'))) {
        $editor = false;
    }
    return $editor;
}

add_filter('user_can_richedit', 'stop_rich_editor');

//TinyMCE追加用のスタイルを初期化
if(!function_exists('initialize_tinymce_styles')) {
    function initialize_tinymce_styles($init_array) {
        //追加するスタイルの配列を作成
        $style_formats = array(
            array(
                'title' => '注釈',
                'inline' => 'span',
                'classes' => 'cmn_note'
            )
        );
        //JSONに変換
        $init_array['style_formats'] = json_encode($style_formats);
        return $init_array;
    }
}

add_filter('tiny_mce_before_init', 'initialize_tinymce_styles', 10000);

// スクリプト定数
function my_script_constants() {
?>
    <script type="text/javascript">
        var templateUrl = '<?php echo T_DIRE_URI; ?>';
        var baseSiteUrl = '<?php echo HOME; ?>';
        var themeAjaxUrl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
    </script>
<?php
}

add_action('wp_head', 'my_script_constants');
add_action('admin_head', 'my_script_constants');

// CSS・スクリプトの読み込み
function theme_add_files() {
    global $post;

	wp_enqueue_style('c-font', T_DIRE_URI.'/assets/font/fonts.css', [], '1.0', 'all');
	
    wp_enqueue_style('c-swiper-bundle', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '1.0', 'all');
    wp_enqueue_style('c-scroll-hint', 'https://unpkg.com/scroll-hint@latest/css/scroll-hint.css', [], '1.0', 'all');
    wp_enqueue_style('c-aos', 'https://unpkg.com/aos@2.3.0/dist/aos.css', [], '1.0', 'all');
    wp_enqueue_style('c-app', T_DIRE_URI.'/assets/css/app.css', [], '1.0', 'all');
    wp_enqueue_style('c-style', T_DIRE_URI.'/style.css', [], '1.2', 'all');
    wp_enqueue_style('c-theme', T_DIRE_URI.'/assets/css/theme.css', [], '1.1', 'all');

    // WordPress本体のjquery.jsを読み込まない
    if(!is_admin()) {
        wp_deregister_script('jquery');
    }

    wp_enqueue_script('s-jquery', T_DIRE_URI.'/assets/js/jquery.min.js', [], '1.0', false);
    wp_enqueue_script('s-swiper-bundle', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '1.0', true);
    wp_enqueue_script('s-scroll-hint', 'https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js', [], '1.0', true);
    wp_enqueue_script('s-aos', 'https://unpkg.com/aos@2.3.0/dist/aos.js', [], '1.0', true);
    wp_enqueue_script('s-app', T_DIRE_URI.'/assets/js/app.js', [], '1.1', true);
    wp_enqueue_script('s-theme', T_DIRE_URI.'/assets/js/theme.js', [], '1.0', true);
}

add_action('wp_enqueue_scripts', 'theme_add_files', 100);

// 管理画面用スクリプトの読み込み
function theme_admin_assets() {
    wp_enqueue_script( 'theme-admin', T_DIRE_URI . '/admin/script.js', array( 'jquery' ) );
}

add_action('admin_enqueue_scripts', 'theme_admin_assets');

// カスタムタクソノミー用のスクリプト
function custom_term_radio_checklist( $args ) {
    if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'product-type' || $args['taxonomy'] === 'category' ) {
        if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { 
            if ( ! class_exists( 'WPSE_139269_Walker_Category_Radio_Checklist' ) ) {
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
                    function walk( $elements, $max_depth, ...$args ) {
                        $output = parent::walk( $elements, $max_depth, ...$args );
                        $output = str_replace(
                            array( 'type="checkbox"', "type='checkbox'" ),
                            array( 'type="radio"', "type='radio'" ),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }
    return $args;
}

add_filter( 'wp_terms_checklist_args', 'custom_term_radio_checklist' );

// テーマサポートの設定
function theme_custom_setup() {
    add_theme_support( 'post-thumbnails' );
    add_image_size( "thumbnail", 780, 516, true );
    add_editor_style('assets/font/fonts.css');
    add_editor_style('assets/css/app.css');
    add_editor_style('editor-style.css');
}

add_action( 'after_setup_theme', 'theme_custom_setup' );

// 画像パスの置換
function replaceImagePath( $arg ) {
    $content = str_replace('"images/', '"' . T_DIRE_URI . '/assets/image/', $arg);
    $content = str_replace('"/images/', '"' . T_DIRE_URI . '/assets/image/', $content);
    $content = str_replace(', images/', ', ' . T_DIRE_URI . '/assets/image/', $content);
    $content = str_replace("('images/", "('". T_DIRE_URI . '/assets/image/', $content);
    return $content;
}

add_action('the_content', 'replaceImagePath');

// 自動改行の無効化
function disable_wp_auto_p( $content ) {
    if ( is_singular( 'page' ) ) {
      remove_filter( 'the_content', 'wpautop' );
    }
    remove_filter( 'the_excerpt', 'wpautop' );
    return $content;
}

add_filter( 'the_content', 'disable_wp_auto_p', 0 );

// クエリ変数の追加
add_filter('query_vars', function($vars) {
	$vars[] = 'news_category';
	return $vars;
});

// 最初の画像の取得
function catch_that_image( $post_id = null ) {
    global $post, $posts;
    if( $post_id ) {
        $post = get_post( $post_id );
    }
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
    if ( ! empty( $matches[1][0] ) ) {
        $first_img = $matches[1][0];
    }

    if ( empty( $first_img ) ) {
      $first_img = T_DIRE_URI . "/assets/image/noimage.png";
    }
    return $first_img;
}

// SVGを許可する
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

// カスタムタクソノミーのチェックボックスをトップに表示
function taxonomy_checklist_checked_ontop_filter ($args) {
    $args['checked_ontop'] = false;
    return $args;
}

add_filter('wp_terms_checklist_args','taxonomy_checklist_checked_ontop_filter');

// 抜粋の文字数の変更
function new_excerpt_length($length) {
    return 100;
}
add_filter('excerpt_length', 'new_excerpt_length');

// 抜粋の末尾に...を追加
function new_excerpt_more($more) {
    return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');

// 閲覧数の設定
function wp_set_post_views( $postID ) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta( $postID, $count_key, true );

    if( $count == '' ) {
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

function wp_get_post_views( $content ) {
    if ( is_single() ) {
        wp_set_post_views(get_the_ID());
    }
    return $content;
}
add_filter( 'the_content', 'wp_get_post_views' );

// 投稿 → コラム に変更
function rename_post_to_column() {
    global $menu, $submenu, $wp_post_types;

    // メニュー名を変更
    $menu[5][0] = 'コラム';
    $submenu['edit.php'][5][0] = 'すべてのコラム';

    // 投稿タイプラベルを変更
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'コラム';
    $labels->singular_name = 'コラム';
    $labels->add_new = '新規追加';
    $labels->add_new_item = '新規コラムを追加';
    $labels->edit_item = 'コラムを編集';
    $labels->new_item = '新規コラム';
    $labels->view_item = 'コラムを表示';
    $labels->search_items = 'コラムを検索';
    $labels->not_found = 'コラムが見つかりません';
    $labels->not_found_in_trash = 'ゴミ箱にコラムはありません';
    $labels->all_items = 'すべてのコラム';
    $labels->menu_name = 'コラム';
    $labels->name_admin_bar = 'コラム';
    $labels->archives = 'コラムアーカイブ';
    $labels->attributes = 'コラム属性';
    $labels->insert_into_item = 'コラムに挿入';
    $labels->uploaded_to_this_item = 'このコラムにアップロードされたファイル';
    $labels->filter_items_list = 'コラムリストのフィルター';
    $labels->items_list_navigation = 'コラムリストのナビゲーション';
    $labels->items_list = 'コラムリスト';
}
add_action( 'init', 'rename_post_to_column' );

// 投稿のリンクを変更
function custom_post_permalink($permalink, $post) {

    if ($post->post_type == 'post') {

        $category = get_the_category($post->ID);

        if ($category) {
            $category_slug = $category[0]->slug;
        } else {
            $category_slug = 'uncategorized';
        }

        return home_url('/column/' . $category_slug . '/' . $post->post_name . '/');
    }

    return $permalink;
}

add_filter('post_link', 'custom_post_permalink', 10, 2);

function custom_column_rewrite_rule() {

    add_rewrite_rule(
        '^column/([^/]+)/([^/]+)/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]',
        'top'
    );

}

add_action('init', 'custom_column_rewrite_rule');

// 前後の記事のリンクを表示
add_filter( 'previous_post_link', 'filter_single_post_pagination', 10, 4 );
add_filter( 'next_post_link',     'filter_single_post_pagination', 10, 4 );

function filter_single_post_pagination( $output, $format, $link, $post )
{
    if( $post ) {
        $title = get_the_title( $post );
        $url   = get_permalink( $post->ID );
        $date  = get_the_time("Y.m.d", $post->ID);
        
        $class = 'prev';
        $label = '前の記事';

        if ( 'next_post_link' === current_filter() ) {
            $class = 'next';
            $label = '次の記事';
        }

        $post_thumbnail = '';
        if ( has_post_thumbnail( $post->ID ) ) {
            $post_thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail' );
        } else {
            $post_thumbnail = '<img src="' . catch_that_image( $post->ID ) . '" alt="' . $title . '" loading="lazy">';
        }

        ob_start();
        ?>

        <a href="<?php echo $url; ?>" class="page-link <?php echo $class; ?>">
            <h5 class="label"><?php echo $label; ?></h5>
            <figure class="thumb">
                <?php echo $post_thumbnail; ?>
            </figure>
            <div class="content">
                <div class="date"><?php echo $date; ?></div>
                <h3 class="title"><?php echo $title; ?></h3>
            </div>
        </a>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    return false;
}

// シェアボタンの表示
function wp_get_share_btns( $post_id = null ) {
    $post_id      = $post_id ? $post_id : get_the_ID();
    $share_title = html_entity_decode( get_the_title( $post_id ) );
    $share_url   = get_permalink( $post_id );
    $share_btns = [
        'twitter' => [
            'title'       => __( 'Twitter', THEME_NOTE ),
            'icon'        => '<i class="fa-brands fa-square-twitter"></i>',
            'href'        => 'https://twitter.com/intent/tweet?url=' .  urlencode( $share_url ) . '&text=' . $share_title . '',
            'class'       => 'twitter-link',
        ],
        'facebook' => [
            'title'       => __( 'Facebook', THEME_NOTE ),
            'icon'        => '<i class="fa-brands fa-square-facebook"></i>',
            'href'        => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $share_url ),
            'class'       => 'facebook-link',
        ],
        'line' => [
            'title'       => __( 'LINE', THEME_NOTE ),
            'icon'        => '<i class="fa-brands fa-line"></i>',
            'href'        => 'https://social-plugins.line.me/lineit/share?url' .  urlencode( $share_url ) . '&text=' . $share_title . '',
            'class'       => 'line-link',
        ],
    ];
    ob_start();
    ?>
    <div class="share-links">
        <span class="label">この記事をシェアする</span>
        <?php foreach ($share_btns as $key => $btn) : ?>
            <a href="<?php echo $btn['href']; ?>" class="<?php echo $btn['class']; ?>">
                <?php echo $btn['icon']; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php 
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
}

require_once T_DIRE . '/inc/template-tags.php';
require_once T_DIRE . '/inc/post-types.php';
require_once T_DIRE . '/inc/contact.php';
require_once T_DIRE . '/inc/seed.php';