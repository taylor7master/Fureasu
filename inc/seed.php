<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fureasu_seed_content() {
    fureasu_seed_pages();
    fureasu_seed_voice_terms();
    fureasu_seed_voices();

    if ( get_option( 'fureasu_rewrite_version' ) !== '2' ) {
        flush_rewrite_rules( false );
        update_option( 'fureasu_rewrite_version', '2' );
    }
}
// add_action( 'init', 'fureasu_seed_content', 30 );

function fureasu_seed_pages() {
    $pages = [
        'about'   => 'フレアスグループの想い',
        'support' => '開業サポート',
        'model'   => '収益モデル',
        'column'  => 'コラム',
        'contact' => '資料請求・お問い合わせ',
        'privacy' => 'プライバシーポリシー',
        'terms'   => '利用規約',
        'thanks'  => '送信完了',
        'faq'     => 'よくあるご質問',
        'news'    => 'お知らせ・ニュース',
        'company' => '会社情報',
        'recruit' => '採用情報',
    ];

    foreach ( $pages as $slug => $title ) {
        $existing = get_page_by_path( $slug );
        if ( $existing ) {
            continue;
        }
        wp_insert_post( [
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => '',
        ] );
    }

    update_option( 'fureasu_pages_seeded', 1 );
}

function fureasu_seed_voice_terms() {
    if ( ! taxonomy_exists( 'voice_type' ) ) {
        return;
    }
    $areas = [
        'north' => '北日本',
        'east'  => '東日本',
        'west'  => '西日本',
    ];
    foreach ( $areas as $slug => $name ) {
        if ( ! term_exists( $slug, 'voice_type' ) ) {
            wp_insert_term( $name, 'voice_type', [ 'slug' => $slug ] );
        }
    }
}

function fureasu_seed_voices() {
    if ( get_option( 'fureasu_voices_seeded' ) ) {
        return;
    }

    $path = T_DIRE . '/inc/voice-seed.json';
    if ( ! file_exists( $path ) ) {
        return;
    }

    $voices = json_decode( file_get_contents( $path ), true );
    if ( ! is_array( $voices ) ) {
        return;
    }

    foreach ( $voices as $voice ) {
        $slug = isset( $voice['slug'] ) ? $voice['slug'] : '';
        if ( $slug === '' ) {
            continue;
        }
        $existing = get_page_by_path( $slug, OBJECT, 'voice' );
        if ( $existing ) {
            continue;
        }

        $post_id = wp_insert_post( [
            'post_type'    => 'voice',
            'post_status'  => 'publish',
            'post_title'   => $voice['title'],
            'post_name'    => $slug,
            'post_excerpt' => $voice['excerpt'],
            'menu_order'   => (int) $voice['menu_order'],
        ] );

        if ( ! $post_id || is_wp_error( $post_id ) ) {
            continue;
        }

        update_post_meta( $post_id, '_voice_data', [
            'position'    => $voice['position'],
            'name'        => $voice['name'],
            'tags'        => $voice['tags'],
            'lead_html'   => $voice['lead_html'],
            'desc_html'   => $voice['desc_html'],
            'image'       => $voice['image'],
            'excerpt'     => $voice['excerpt'],
            'faqs'        => $voice['faqs'],
            'bottom_lead' => $voice['bottom_lead'],
            'bottom_desc' => $voice['bottom_desc'],
        ] );

        $area = isset( $voice['area'] ) ? $voice['area'] : '';
        if ( in_array( $area, [ 'north', 'east', 'west' ], true ) ) {
            wp_set_object_terms( $post_id, $area, 'voice_type' );
        }
    }

    update_option( 'fureasu_voices_seeded', 1 );
}
