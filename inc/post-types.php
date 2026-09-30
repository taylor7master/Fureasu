<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fureasu_register_content_types() {
    register_post_type( 'voice', [
        'labels' => [
            'name'               => 'オーナーの声',
            'singular_name'      => 'オーナーの声',
            'add_new'            => '新規追加',
            'add_new_item'       => 'オーナーの声を追加',
            'edit_item'          => 'オーナーの声を編集',
            'new_item'           => '新規オーナーの声',
            'view_item'          => 'オーナーの声を表示',
            'search_items'       => 'オーナーの声を検索',
            'not_found'          => 'オーナーの声が見つかりません',
            'not_found_in_trash' => 'ゴミ箱にオーナーの声はありません',
            'all_items'          => 'オーナーの声一覧',
            'menu_name'          => 'オーナーの声',
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-format-quote',
        'menu_position'=> 6,
        'rewrite'      => [ 'slug' => 'voice', 'with_front' => false ],
        'supports'     => [ 'title', 'excerpt', 'thumbnail', 'page-attributes' ],
        'show_in_rest' => false,
    ] );

    register_taxonomy( 'voice_type', 'voice', [
        'labels' => [
            'name'          => '区分',
            'singular_name' => '区分',
            'search_items'  => '区分を検索',
            'all_items'     => 'すべての区分',
            'edit_item'     => '区分を編集',
            'add_new_item'  => '区分を追加',
            'menu_name'     => '区分',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'voice-type', 'with_front' => false ],
        'show_in_rest'      => false,
    ] );
}
add_action( 'init', 'fureasu_register_content_types' );

function fureasu_voice_meta_box() {
    add_meta_box(
        'fureasu_voice_details',
        'プロフィール',
        'fureasu_voice_meta_box_html',
        'voice',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'fureasu_voice_meta_box' );

function fureasu_voice_meta_box_html( $post ) {
    $data = fureasu_get_voice_data( $post->ID );
    $terms = wp_get_object_terms( $post->ID, 'voice_type', [ 'fields' => 'slugs' ] );
    $current_type = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0] : '';
    wp_nonce_field( 'fureasu_voice_save', 'fureasu_voice_nonce' );
    $faqs = $data['faqs'];
    if ( count( $faqs ) < 3 ) {
        $faqs = array_pad( $faqs, 3, [
            'reverse' => false,
            'num' => '',
            'q' => '',
            'lead' => '',
            'desc' => '',
            'image' => '',
            'image_alt' => '',
        ] );
    }
    ?>
    <p><label>肩書き<br><textarea name="voice_position" rows="2" class="large-text"><?php echo esc_textarea( $data['position'] ); ?></textarea></label></p>
    <p><label>氏名<br><input type="text" name="voice_name" class="large-text" value="<?php echo esc_attr( $data['name'] ); ?>"></label></p>
    <p><label>見出し（改行は &lt;br&gt;）<br><textarea name="voice_lead_html" rows="2" class="large-text"><?php echo esc_textarea( $data['lead_html'] ); ?></textarea></label></p>
    <p><label>紹介文<br><textarea name="voice_desc_html" rows="5" class="large-text"><?php echo esc_textarea( $data['desc_html'] ); ?></textarea></label></p>
    <p><label>一覧用タグ（カンマ区切り）<br><input type="text" name="voice_tags" class="large-text" value="<?php echo esc_attr( implode( ', ', (array) $data['tags'] ) ); ?>"></label></p>
    <p><label>開業年数<br><input type="text" name="voice_year" class="regular-text" value="<?php echo esc_attr( $data['year'] ); ?>"></label></p>
    <p><label>売上<br><input type="text" name="voice_sales" class="regular-text" value="<?php echo esc_attr( $data['sales'] ); ?>"></label></p>
    <p><label>画像パス（テーマ assets/image からの相対パス。アイキャッチがあればそちらを優先）<br><input type="text" name="voice_image" class="large-text" value="<?php echo esc_attr( $data['image'] ); ?>"></label></p>
    <p>
        <label>区分<br>
            <select name="voice_type">
                <option value="">未設定</option>
                <option value="corporate" <?php selected( $current_type, 'corporate' ); ?>>法人</option>
                <option value="individual" <?php selected( $current_type, 'individual' ); ?>>個人</option>
            </select>
        </label>
    </p>
    <hr>
    <h4>インタビュー</h4>
    <?php foreach ( $faqs as $index => $faq ) : ?>
        <div style="margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #ddd;">
            <p><strong>Q<?php echo (int) $index + 1; ?></strong>
                <label style="margin-left:12px;"><input type="checkbox" name="voice_faq[<?php echo (int) $index; ?>][reverse]" value="1" <?php checked( ! empty( $faq['reverse'] ) ); ?>> 左右反転</label>
            </p>
            <p><label>質問<br><textarea name="voice_faq[<?php echo (int) $index; ?>][q]" rows="2" class="large-text"><?php echo esc_textarea( $faq['q'] ?? '' ); ?></textarea></label></p>
            <p><label>回答見出し<br><textarea name="voice_faq[<?php echo (int) $index; ?>][lead]" rows="2" class="large-text"><?php echo esc_textarea( $faq['lead'] ?? '' ); ?></textarea></label></p>
            <p><label>回答本文<br><textarea name="voice_faq[<?php echo (int) $index; ?>][desc]" rows="4" class="large-text"><?php echo esc_textarea( $faq['desc'] ?? '' ); ?></textarea></label></p>
            <p><label>画像パス<br><input type="text" name="voice_faq[<?php echo (int) $index; ?>][image]" class="large-text" value="<?php echo esc_attr( $faq['image'] ?? '' ); ?>"></label></p>
        </div>
    <?php endforeach; ?>
    <p><label>締めの見出し<br><input type="text" name="voice_bottom_lead" class="large-text" value="<?php echo esc_attr( $data['bottom_lead'] ); ?>"></label></p>
    <p><label>締めの本文<br><textarea name="voice_bottom_desc" rows="3" class="large-text"><?php echo esc_textarea( $data['bottom_desc'] ); ?></textarea></label></p>
    <?php
}

function fureasu_save_voice_meta( $post_id ) {
    if ( ! isset( $_POST['fureasu_voice_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fureasu_voice_nonce'] ) ), 'fureasu_voice_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $tags = array_filter( array_map( 'trim', explode( ',', sanitize_text_field( wp_unslash( $_POST['voice_tags'] ?? '' ) ) ) ) );
    $faqs = [];
    $posted_faqs = isset( $_POST['voice_faq'] ) && is_array( $_POST['voice_faq'] ) ? wp_unslash( $_POST['voice_faq'] ) : [];
    foreach ( $posted_faqs as $index => $faq ) {
        $question = isset( $faq['q'] ) ? wp_kses( $faq['q'], [ 'br' => [ 'class' => true ] ] ) : '';
        $lead     = isset( $faq['lead'] ) ? wp_kses( $faq['lead'], [ 'br' => [ 'class' => true ] ] ) : '';
        $desc     = isset( $faq['desc'] ) ? sanitize_textarea_field( $faq['desc'] ) : '';
        if ( $question === '' && $lead === '' && $desc === '' ) {
            continue;
        }
        $faqs[] = [
            'reverse'   => ! empty( $faq['reverse'] ),
            'num'       => 'Q' . mb_convert_kana( (string) ( count( $faqs ) + 1 ), 'N' ),
            'q'         => $question,
            'lead'      => $lead,
            'desc'      => $desc,
            'image'     => isset( $faq['image'] ) ? sanitize_text_field( $faq['image'] ) : '',
            'image_alt' => wp_strip_all_tags( $question ),
        ];
    }

    $data = [
        'position'    => wp_kses( wp_unslash( $_POST['voice_position'] ?? '' ), [ 'br' => [ 'class' => true ] ] ),
        'name'        => sanitize_text_field( wp_unslash( $_POST['voice_name'] ?? '' ) ),
        'tags'        => $tags,
        'lead_html'   => wp_kses( wp_unslash( $_POST['voice_lead_html'] ?? '' ), [ 'br' => [ 'class' => true ] ] ),
        'desc_html'   => sanitize_textarea_field( wp_unslash( $_POST['voice_desc_html'] ?? '' ) ),
        'image'       => sanitize_text_field( wp_unslash( $_POST['voice_image'] ?? '' ) ),
        'year'        => sanitize_text_field( wp_unslash( $_POST['voice_year'] ?? '' ) ),
        'sales'       => sanitize_text_field( wp_unslash( $_POST['voice_sales'] ?? '' ) ),
        'excerpt'     => '',
        'faqs'        => $faqs,
        'bottom_lead' => sanitize_text_field( wp_unslash( $_POST['voice_bottom_lead'] ?? '' ) ),
        'bottom_desc' => sanitize_textarea_field( wp_unslash( $_POST['voice_bottom_desc'] ?? '' ) ),
    ];
    $data['excerpt'] = wp_strip_all_tags( $data['desc_html'] );
    update_post_meta( $post_id, '_voice_data', $data );

    $type = sanitize_text_field( wp_unslash( $_POST['voice_type'] ?? '' ) );
    if ( in_array( $type, [ 'corporate', 'individual' ], true ) ) {
        wp_set_object_terms( $post_id, $type, 'voice_type' );
    } else {
        wp_set_object_terms( $post_id, [], 'voice_type' );
    }
}
add_action( 'save_post_voice', 'fureasu_save_voice_meta' );
