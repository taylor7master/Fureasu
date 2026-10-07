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
            <span class="fcta__lead">お問い合わせ</span>
            <span class="fcta__ttl">0120-14-2013</span>
            <span class="fcta__lead">平日 9:00〜18:00</span>
          </a>
        </div>
      </div>
      <div>
        <div class="ft__cols">
          <div class="fcol fcol--other">
            <ul>
              <li><a href="<?php echo esc_url( HOME . 'about/' ); ?>">FCについて</a></li>
              <li><a href="<?php echo esc_url( HOME . 'support/' ); ?>">開業までの流れ</a></li>
              <li><a href="<?php echo esc_url( HOME . 'model/' ); ?>">収益モデル</a></li>
            </ul>
          </div>
          <div class="fcol fcol--other">
            <ul>
              <li><a href="<?php echo esc_url( HOME . 'voice/' ); ?>">加盟オーナーの声</a></li>
              <li><a href="<?php echo esc_url( HOME . 'column/' ); ?>">コラム</a></li>
              <li><a href="<?php echo esc_url( HOME . 'faq/' ); ?>">よくあるご質問</a></li>
            </ul>
          </div>
          <div class="fcol fcol--other">
            <ul>
              <li><a href="<?php echo esc_url( HOME . 'support/' ); ?>">開業サポート</a></li>
              <li><a href="https://recruit.fureasu.jp/news/" target="_blank" rel="noopener">お知らせ・ニュース</a></li>
            </ul>
          </div>
          <div class="fcol fcol--other">
            <ul>
              <li><a href="https://fureasu.jp/" target="_blank" rel="noopener">会社情報</a></li>
              <li><a href="https://recruit.fureasu.jp/" target="_blank" rel="noopener">採用情報</a></li>
            </ul>
          </div>
        </div>
        <div class="ft__right-bottom">
          <div class="ft__sns">
            <a href="https://www.instagram.com/fureasu_recruit/" target="_blank" rel="noopener" class="sns-ic sns-ic--ig" aria-label="Instagram（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/instagram.png' ); ?>" alt="Instagram"></a>
            <a href="https://x.com/fureasu_recruit" target="_blank" rel="noopener" class="sns-ic sns-ic--x" aria-label="X（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/xcom.png' ); ?>" alt="X"></a>
            <a href="https://www.tiktok.com/@fureasu_recruit/" target="_blank" rel="noopener" class="sns-ic sns-ic--tiktok" aria-label="TikTok（新しいタブで開きます）"><img src="<?php echo esc_url( $rc . '/sns/tiktok.png' ); ?>" alt="TikTok"></a>
          </div>
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
