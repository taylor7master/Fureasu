    </main>

<?php
$fc_meet    = 'https://fureasu.youcanbook.me/';
$fc_contact = HOME . 'contact/';
$fc_tel     = 'tel:0120142013';
$rc         = T_DIRE_URI . '/assets/image/recruit';
?>

<footer class="ft">
  <div class="wrap">
    <div class="ft__inner">
      <div>
        <div class="ft__logo-row">
          <p class="ft__logo"><img src="<?php echo esc_url( $rc . '/logo_fureasu.svg' ); ?>" alt="fureasu" class="ft__logo-img"></p>
          <div class="ft__searchwrap">
            <p class="ft__search-lead">説明会・資料請求は<br>こちらから</p>
            <a href="<?php echo esc_url( $fc_contact ); ?>" class="ft__search">資料請求はこちら</a>
          </div>
        </div>
        <p class="ft__addr">〒141-0031 東京都品川区西五反田二丁目27番3号（A-PLACE五反田3F）</p>
        <div class="ft__group ft__group--related">
          <p class="ft__group-ttl ft__group-ttl--related">関連サイト</p>
          <div class="ft__pills">
            <a href="https://fureasu.jp/" target="_blank" rel="noopener" class="ft__pill ft__pill--corporate">コーポレートサイト ↗</a>
            <a href="https://fureasu.jp/business/" target="_blank" rel="noopener" class="ft__pill ft__pill--service">サービスサイト ↗</a>
            <a href="https://recruit.fureasu.jp/" target="_blank" rel="noopener" class="ft__pill ft__pill--fc">採用サイト ↗</a>
          </div>
        </div>
        <div class="ft__group ft__group--brands">
          <p class="ft__group-ttl ft__group-ttl--brands">グループサイト</p>
          <div class="ft__pills">
            <a href="https://leis.jp/" target="_blank" rel="noopener" class="ft__pill ft__pill--leis">株式会社オルテンシア<br class="br-sp">ハーモニー ↗</a>
            <a href="https://kindcare.fureasu.jp/" target="_blank" rel="noopener" class="ft__pill ft__pill--kindcare">フレアスカインドケア<br class="br-sp">株式会社 ↗</a>
          </div>
        </div>
        <div class="ft__ctas">
          <a href="<?php echo esc_url( $fc_tel ); ?>" class="hcta hcta--tel">
            <span class="hcta__lead">お問い合わせ</span>
            <span class="hcta__tel">0120-14-2013</span>
            <span class="hcta__lead">平日 9:00〜18:00</span>
          </a>
          <a href="<?php echo esc_url( $fc_contact ); ?>" class="hcta hcta--form">
            <span class="hcta__ttl">無料資料請求・<br>お問い合わせ</span>
          </a>
          <a href="<?php echo esc_url( $fc_meet ); ?>" target="_blank" rel="noopener" class="hcta hcta--line">
            <span class="hcta__ttl">無料説明会</span>
          </a>
        </div>
      </div>
      <div>
        <div class="ft__cols">
          <div class="fcol fcol--about">
            <p class="fcol__ttl"><a href="<?php echo esc_url( HOME . 'about/' ); ?>">FCについて</a></p>
            <ul class="au-top-ft-ul1">
              <li class="au-top-ft-li1"><a class="au-top-ft-a2 scrollto" href="<?php echo esc_url( HOME . 'about/#about-intro' ); ?>">グループの想い</a></li>
              <li class="au-top-ft-li2"><a class="au-top-ft-a3 scrollto" href="<?php echo esc_url( HOME . 'about/#about-message' ); ?>">代表メッセージ</a></li>
              <li class="au-top-ft-li3"><a class="au-top-ft-a4 scrollto" href="<?php echo esc_url( HOME . 'about/#about-vision' ); ?>">こんな方と一緒に</a></li>
            </ul>
          </div>
          <div class="fcol fcol--support">
            <p class="fcol__ttl"><a href="<?php echo esc_url( HOME . 'support/' ); ?>">開業サポート</a></p>
            <ul class="au-top-ft-ul2">
              <li class="au-top-ft-li5"><a class="au-top-ft-a5 scrollto" href="<?php echo esc_url( HOME . 'support/#support-system' ); ?>">サポート体制</a></li>
              <li class="au-top-ft-li5"><a class="au-top-ft-a6 scrollto" href="<?php echo esc_url( HOME . 'support/#support-ba' ); ?>">開業サポート</a></li>
              <li class="au-top-ft-li7"><a class="au-top-ft-a7 scrollto" href="<?php echo esc_url( HOME . 'support/#support-guide' ); ?>">募集要項</a></li>
              <li class="au-top-ft-li8"><a class="au-top-ft-a8 scrollto" href="<?php echo esc_url( HOME . 'support/#support-steps' ); ?>">開業までの流れ</a></li>
            </ul>
          </div>
          <div class="fcol fcol--model">
            <p class="fcol__ttl"><a href="<?php echo esc_url( HOME . 'model/' ); ?>">収益モデル</a></p>
            <ul class="au-top-ft-ul3">
              <li class="au-top-ft-li9"><a class="au-top-ft-a9 scrollto" href="<?php echo esc_url( HOME . 'model/#model-calc' ); ?>">収益の考え方</a></li>
              <li class="au-top-ft-li10"><a class="au-top-ft-a10 scrollto" href="<?php echo esc_url( HOME . 'model/#model-stock' ); ?>">ストック型ビジネス</a></li>
              <li class="au-top-ft-li11"><a class="au-top-ft-a11 scrollto" href="<?php echo esc_url( HOME . 'model/#model-reason' ); ?>">収益のロジック</a></li>
            </ul>
          </div>
          <div class="fcol fcol--other">
            <p class="fcol__ttl fcol__ttl--other sp-only">その他</p>
            <ul class="au-top-ft-ul4">
              <li class="au-top-ft-li12"><a href="<?php echo esc_url( HOME . 'voice/' ); ?>">オーナーの声</a></li>
              <li class="au-top-ft-li13"><a href="<?php echo esc_url( HOME . 'column/' ); ?>">コラム</a></li>
              <li class="au-top-ft-li14"><a href="<?php echo esc_url( HOME . 'contact/' ); ?>">お問い合わせ</a></li>
            </ul>
          </div>
        </div>
        <div class="ft__right-bottom">
          <!-- <div class="ft__sns">
            <a href="https://www.instagram.com/fureasu_recruit/" target="_blank" rel="noopener" class="sns-ic sns-ic--ig" aria-label="Instagram（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/instagram.png' ); ?>" alt="Instagram"></a>
            <a href="https://x.com/fureasu_recruit" target="_blank" rel="noopener" class="sns-ic sns-ic--x" aria-label="X（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/xcom.png' ); ?>" alt="X"></a>
            <a href="https://www.tiktok.com/@fureasu_recruit/" target="_blank" rel="noopener" class="sns-ic sns-ic--tiktok" aria-label="TikTok（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/tiktok.png' ); ?>" alt="TikTok"></a>
          </div> -->
          <div class="ft__japhic"><img src="<?php echo esc_url( $rc . '/sns/japhic1.png' ); ?>" alt="JAPHICマーク" class="ft__japhic-1"><img src="<?php echo esc_url( $rc . '/sns/japhic2.png' ); ?>" alt="JAPHICマーク（メディカル）" class="ft__japhic-2"></div>
        </div>
        <div class="ft__legal">
          <a href="<?php echo esc_url( HOME . 'privacy/' ); ?>">プライバシーポリシー</a><span aria-hidden="true">｜</span>
          <a href="<?php echo esc_url( HOME . 'terms/' ); ?>">利用規約</a>
        </div>
      </div>
    </div>
  </div>
  <div class="ft__band">© fureasu group All Rights Reserved</div>
</footer>

    <?php wp_footer(); ?>

    <script>
        if (document.querySelector('.voice-list-swiper') && typeof Swiper !== 'undefined') {
        const voiceSwiper = new Swiper('.voice-list-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 16,
            centeredSlides: true,
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    spaceBetween: 45,
                },
            },
        });
        }
    </script>
</body>

</html>
