<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" style="margin-top: 0 !important;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta property="og:locale" content="ja_JP">

    <!-- SEO Meta Tags -->
    <meta name="keywords" content="在宅鍼灸マッサージ,看護小規模多機能型居宅介護,訪問看護,訪問介護,フレアス" />
    <meta name="description" content="在宅鍼灸マッサージや看護小規模多機能型居宅介護（かんたき）、訪問看護、訪問介護なら【株式会社フレアス】。株式会社フレアスは全国各地の事業所からご利用者様のご自宅・施設に直接訪問、マッサージや訪問看護・訪問介護サービスをお届けします。＜日本の在宅事情を明るくしたい＞。" />

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:title" content="株式会社フレアス" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://fureasu.jp/" />
    <meta property="og:image" content="<?php echo T_DIRE_URI; ?>/assets/image/OGP.jpg" />
    <meta property="og:site_name" content="株式会社フレアス" />
    <meta property="og:description" content="在宅鍼灸マッサージや看護小規模多機能型居宅介護（かんたき）、訪問看護、訪問介護なら【株式会社フレアス】。株式会社フレアスは全国各地の事業所からご利用者様のご自宅・施設に直接訪問、マッサージや訪問看護・訪問介護サービスをお届けします。＜日本の在宅事情を明るくしたい＞。" />

    <!-- Webpage Title -->
    <title>
        <?php if (is_front_page() || is_home()) {
            echo get_bloginfo('name');
        } else {
            wp_title('|', true, 'right');
            echo bloginfo('name');
        } ?>
    </title>

    <!-- favicon -->
    <link rel="icon" href="<?php echo T_DIRE_URI; ?>/assets/image/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Noto+Sans+JP:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
    (function () {
        try {
            var mono = localStorage.getItem('fureasuMono') === '1';
            if (!mono) {
                var saved = JSON.parse(localStorage.getItem('fr_a11y') || '{}');
                mono = !!(saved && saved.mono);
            }
            if (mono) {
                document.documentElement.setAttribute('data-a11y-mono', '1');
            }
        } catch (e) {}
    })();
    </script>
    <?php wp_head(); ?>

</head>

<?php
global $post;
$post_slug = '';

if ( is_singular( 'voice' ) || is_post_type_archive( 'voice' ) || is_tax( 'voice_type' ) ) {
    $post_slug = 'voice';
} elseif ( is_singular( 'post' ) || is_category() || is_tag() || is_page( 'column' ) || is_search() ) {
    $post_slug = 'column';
} elseif ( is_page() ) {
    $post_slug = $post->post_name;
    if ( $post->post_parent > 0 ) {
        $post_slug = get_post( $post->post_parent )->post_name;
    }
} elseif ( is_post_type_archive() ) {
    $post_type = get_query_var( 'post_type' );
    if ( $post_type ) {
        $post_slug = is_array( $post_type ) ? $post_type[0] : $post_type;
    }
}
?>

<body>

<?php
$fc_meet    = 'https://fureasu.youcanbook.me/';
$fc_contact = HOME . 'contact/';
$fc_tel     = 'tel:0120142013';
$fc_nav     = array(
    array( 'url' => HOME, 'label' => 'TOP', 'current' => is_front_page() || is_home() ),
    array( 'url' => HOME . 'about/', 'label' => 'FCについて', 'current' => $post_slug === 'about' ),
    array( 'url' => HOME . 'support/', 'label' => '開業サポート', 'current' => $post_slug === 'support' ),
    array( 'url' => HOME . 'model/', 'label' => '収益モデル', 'current' => $post_slug === 'model' ),
    array( 'url' => HOME . 'voice/', 'label' => 'オーナーの声', 'current' => $post_slug === 'voice' ),
    array( 'url' => HOME . 'faq/', 'label' => 'FAQ', 'current' => $post_slug === 'faq' ),
    array( 'url' => HOME . 'column/', 'label' => 'コラム', 'current' => $post_slug === 'column' ),
);
$rc = T_DIRE_URI . '/assets/image/recruit';
?>

<a href="#main" class="skip-link">本文へ移動</a>
<header class="hd">
  <div class="hd__inner">
    <a href="<?php echo esc_url( HOME ); ?>" class="hd__logo">
      <img src="<?php echo esc_url( $rc . '/logo_fureasu.svg' ); ?>" alt="fureasu" class="hd__logo-img"><span class="hd__logo-sub">フランチャイズ<br>加盟店募集サイト</span>
    </a>
    <div class="hd__right">
      <div class="hd__navblock">
        <div class="hd__a11y">
          <p class="hd__note">本サイトは、視覚的に閲覧が難しい方へ音声読み上げ対応をしております</p>
          <div class="a11y-bar" data-a11y-bar>
            <button type="button" class="a11y-btn a11y-btn--mono" data-a11y-mono aria-pressed="false">モノクロモード <span data-a11y-state>OFF</span></button>
          </div>
        </div>
        <nav class="gnav" aria-label="メインメニュー">
          <ul>
            <?php foreach ( $fc_nav as $item ) : ?>
            <li><a href="<?php echo esc_url( $item['url'] ); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
      <div class="hd__ctas">
        <a href="<?php echo esc_url( $fc_meet ); ?>" target="_blank" rel="noopener" class="hcta hcta--form">
          <span class="hcta__lead">ご予約はこちら</span>
          <span class="hcta__ttl">無料<br>説明会</span>
        </a>
        <a href="<?php echo esc_url( $fc_contact ); ?>" class="hcta hcta--line">
          <span class="hcta__lead">無料でお届け</span>
          <span class="hcta__ttl">資料請求</span>
        </a>
        <a href="<?php echo esc_url( $fc_tel ); ?>" class="hcta hcta--tel">
          <span class="hcta__lead">お問い合わせ</span>
          <span class="hcta__tel">0120-14-2013</span>
          <span class="hcta__lead">平日 9:00〜18:00</span>
        </a>
      </div>
    </div>
  </div>
  <div class="hd__sp">
    <a href="<?php echo esc_url( HOME ); ?>" class="hd__sp-logo">
      <img src="<?php echo esc_url( $rc . '/logo_fureasu.svg' ); ?>" alt="fureasu"><span>フランチャイズ<br>加盟店募集サイト</span>
    </a>
    <a href="<?php echo esc_url( $fc_meet ); ?>" class="hd__sp-entry" target="_blank" rel="noopener">
      <small>ご予約はこちら</small>
      <b>無料説明会</b>
      <span class="hd__sp-pill">説明会に参加</span>
    </a>
    <button class="hd__sp-menu" type="button" aria-label="メニュー" aria-expanded="false" aria-controls="drawer"><span></span><span></span><span></span></button>
  </div>
</header>

<div class="drawer" id="drawer" role="dialog" aria-modal="true" aria-label="メニュー">
  <div class="drawer__panel">
    <div class="drawer__fixed">
      <div class="drawer__head">
        <a href="<?php echo esc_url( HOME ); ?>" class="drawer__logo"><img src="<?php echo esc_url( $rc . '/logo_fureasu.svg' ); ?>" alt="fureasu"><span class="drawer__logo-sub">フランチャイズ<br>加盟店募集サイト</span></a>
        <button class="drawer__close" type="button" aria-label="閉じる">×</button>
      </div>
      <div class="a11y-bar" data-a11y-bar>
        <button type="button" class="a11y-btn a11y-btn--mono" data-a11y-mono aria-pressed="false">モノクロモード <span data-a11y-state>OFF</span></button>
      </div>
    </div>
    <nav aria-label="メニュー">
      <ul>
        <?php foreach ( $fc_nav as $item ) : ?>
        <li><a href="<?php echo esc_url( $item['url'] ); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="drawer__cta">
      <span class="drawer__cta-lead">説明会・資料請求は<br>こちらから</span>
      <a href="<?php echo esc_url( $fc_contact ); ?>" class="drawer__cta-btn">資料請求はこちら</a>
    </div>
    <div class="drawer__ctas">
      <a href="<?php echo esc_url( $fc_meet ); ?>" target="_blank" rel="noopener" class="fcta fcta--form">
        <span class="fcta__lead">ご予約はこちら</span>
        <span class="fcta__ttl">無料説明会</span>
        <span class="fcta__btn">説明会に参加 →</span>
      </a>
      <a href="<?php echo esc_url( $fc_contact ); ?>" class="fcta fcta--line">
        <span class="fcta__lead">無料でお届け</span>
        <span class="fcta__ttl">資料請求</span>
        <span class="fcta__btn">フォームで請求 →</span>
      </a>
      <a href="<?php echo esc_url( $fc_tel ); ?>" class="fcta fcta--tel">
        <span class="fcta__lead">お電話</span>
        <span class="fcta__ttl">0120-14-2013</span>
        <span class="fcta__lead">平日 9:00〜18:00</span>
      </a>
      <a href="<?php echo esc_url( $fc_contact ); ?>" class="fcta fcta--contact">加盟に関する<br>お問い合わせ</a>
    </div>
    <div class="drawer__visit">
      <p class="drawer__visit-ttl">無料説明会</p>
      <p class="drawer__visit-txt">まずは説明会でご相談ください。<br>オンラインでご参加いただけます。</p>
      <a href="<?php echo esc_url( $fc_meet ); ?>" target="_blank" rel="noopener" class="btn-yl drawer__visit-btn">説明会に参加</a>
    </div>
  </div>
</div>

<main id="main">
