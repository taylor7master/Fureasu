<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<section class="about-intro-section">
    <div class="intro-main-wrapper">
        <div class="container">
            <div class="section-body">
                <div class="section-title">
                    <h2 class="en">ABOUTUS</h2>
                    <p class="jp">フレアスグループの想い</p>
                </div>
                <h3 class="section-lead">同じ景色を、<br>一緒に見てくれる人へ。</h3>
                <div class="section-desc">急速に広がる全国の在宅ケアニーズへ、地域密着でスピーディに応えてくいきたい。<br>オーナー様の情熱と地元の信頼を持つオーナー様の想いと私たちのノウハウを掛け合わせ、<br>共に持続可能な社会課題の解決を目指します。</div>
            </div>
            <div class="section-pictures">
                <figure class="image1 scrt-cover">
                    <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/about/about01.png" alt="フレアスグループの想い" loading="lazy">
                </figure>
                <figure class="image2 scrt-cover">
                    <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/about/about02.png" alt="フレアスグループの想い" loading="lazy">
                </figure>
            </div>
        </div>
    </div>
    <div class="intro-profile-wrapper">
        <div class="container">
            <div class="profile-body">
                <h3 class="lead">看取り難民ゼロを目指して</h3>
                <div class="desc">「最期は自宅で」と願っても、支える手が足り<br class="sp-only">ずにそれが叶わない人がいます。<br>病院のベッドは限られ、住み慣れた家で過ごしたいという願いは、年々叶えにくくなっています。<br>高齢者人口がピークを迎える2040年に向けて、<br class="sp-only">その数はさらに増えていきます。<br class="sp-only"><br>私たちの使命は、看取り難民をゼロにすること。<br>一人ひとりが、その人らしい時間を<br class="sp-only">最期まで過ごせるように。<br>「時間の価値の最大化」を掲げ、私たちは日本の在宅事情を明るくすることを目指してきました。<br class="sp-only"><br>そのために、療養から看取りまでを支える在宅医療の網を、日本中に張りめぐらせる必要があります。<br class="sp-only"><br>でも、拠点はまだ全然足りていません。想いだけでは、必要とされている方々に届きません。<br class="sp-only"><br>在宅療養を続ける全国の方へ、必要な時に、速やかにサービスを届ける仕組みが必要です。<br>フレアスが直営で培ってきたノウハウの<br class="sp-only">すべてを携えて。<br>その担い手が、加盟オーナーの皆さんです。</div>
            </div>
            <div class="profile-side">
                <figure class="avatar scrt-cover">
                    <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/about/profile.png" alt="看取り難民ゼロを目指して" loading="lazy">
                </figure>
                <p class="meta">株式会社フレアス　代表取締役社長 CEO<br>鍼灸マッサージ師<br>一般社団法人 山梨県はり師きゅう師<br class="sp-only">マッサージ師会 会長</p>
                <p class="name">澤登 拓</p>
            </div>
        </div>
    </div>
</section>

<section class="about-mission-section">
    <div class="container">
        <div class="mission-wrapper">
            <figure class="mission-image scrt-cover">
                <img src="<?php echo esc_url( T_DIRE_URI ); ?>/assets/image/about/mission.png" alt="ミッション" loading="lazy">
            </figure>
            <div class="mission-body">
                <p class="lead">私たちの想いだけでなく、<br class="sp-only">願いが混ざります。<br>先に踏み出したオーナーたちの、<br class="sp-only">生の声も聞いてみてください。</p>
                <div class="action">
                    <a href="<?php echo esc_url( HOME . 'voice/' ); ?>" class="link-btn link-btn--secondary">
                        <span>他のオーナーの声をもっと見る</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-vision-section">
    <div class="container">
        <div class="vision-wrapper">
            <div class="section-lead">
                <p>こんな方と一緒にやりたい</p>
                <h2>未経験・無資格からでも大丈夫です。</h2>
            </div>
            <div class="section-content">
                <ul class="vision-list">
                    <li>地域の高齢者に、<span><em>本気で向き合う</em><em>覚悟がある</em></span></li>
                    <li>スタッフを「コスト」ではなく<span class="pl"><em>「仲間」</em><em>として見られる</em></span></li>
                    <li>短期の利益より、<span><em>10年続く事業を作りたい</em></span></li>
                    <li>わからないことを <span><em>素直に聞ける</em></span></li>
                    <li>フレアスの理念に <span><em>心から共感できる</em></span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php get_template_part( 'template-parts/banner' ); ?>

<?php get_footer(); ?>
