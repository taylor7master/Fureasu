<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<section class="contact-firstview">
    <div class="container">
        <div class="section-title">
            <h2 class="en">PRIVACY POLICY</h2>
            <p class="jp">プライバシーポリシー</p>
        </div>
    </div>
</section>

<section class="page-privacy">
    <div class="container">
        <div class="privacy-body">
            <p class="privacy-lead">株式会社フレアス（以下、「当社」）は、当社が運営するウェブサイト（以下、「当サイト」）の利用者（以下、「ユーザー」）から取得した個人情報の取扱いに関し、個人情報の保護に関する法律、ガイドライン等の指針、その他個人情報保護に関する関係法令を遵守します。</p>

            <section class="privacy-section">
                <h2 class="privacy-heading">1. 個人情報の安全管理</h2>
                <p>当社は、個人情報の保護に関して、組織的、物理的、人的、技術的に適切な対策を実施し、取り扱う個人情報の漏えい、滅失又はき損の防止その他の個人情報の安全管理のために必要かつ適切な措置を講ずるものとします。</p>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">2. 個人情報の取得</h2>
                <p>当社は、以下の情報の提供をユーザーに求めることがあります。</p>
                <ul>
                    <li>資料請求・お問い合わせ時： 氏名、郵便番号、住所、電話番号、メールアドレス、事業形態、お問い合わせ内容</li>
                    <li>アクセス情報： クッキー（Cookie）、IPアドレス、ブラウザの種類、アクセス日時（個人を特定しない統計データとして）</li>
                </ul>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">3. 利用目的</h2>
                <p>当社が取得した個人情報は、以下の目的の範囲内で利用し、本人の同意がある場合又は法令に定める場合を除き、目的外利用はいたしません。</p>
                <ul>
                    <li>当サイトの運営、維持、管理</li>
                    <li>資料請求・お問い合わせへの回答および本人確認</li>
                    <li>フランチャイズ加盟に関するご案内、説明会のご連絡</li>
                    <li>サイト利便性向上のためのアクセス解析</li>
                </ul>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">4. 個人情報の第三者提供</h2>
                <p>当社は、次の場合を除いて、無断で個人情報を第三者に提供することはありません。</p>
                <ul>
                    <li>本人の同意がある場合</li>
                    <li>法令に基づく場合</li>
                    <li>利用目的の達成に必要な範囲内において業務委託先等に提供する場合</li>
                    <li>個人情報をご提供いただく際に予め明示した第三者に提供する場合</li>
                    <li>その他正当な理由がある場合</li>
                </ul>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">5. 個人情報の利用目的の変更</h2>
                <p>当社は、前項で特定した利用目的を、変更前の利用目的と相当の関連性を有すると合理的に認められる範囲において変更することがあります。その場合は、変更後の利用目的を当サイト上で公表いたします。</p>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">6. クッキー（Cookie）の利用について</h2>
                <p>当サイトでは、ユーザーの利便性向上やサイト改善のため、クッキーを使用することがあります。ユーザーはブラウザの設定によりクッキーの受け取りを拒否することができますが、その場合、当サイトの一部機能が利用できない場合があります。</p>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">7. 個人情報の開示・訂正・廃棄</h2>
                <p>当社は、本人から個人情報の開示、訂正、追加、削除を求められた場合は、遅滞なくこれを行います。また、利用目的に照らし、その必要性が失われた個人情報については、速やかに消去又は廃棄します。</p>
            </section>

            <section class="privacy-section">
                <h2 class="privacy-heading">8. お問い合わせ窓口</h2>
                <p>本ポリシーに関するお問い合わせ、および個人情報の取扱いに関するご相談は、以下の窓口までご連絡ください。</p>
                <div class="privacy-contact-box">
                    <ol>
                        <li>サイト運営者：株式会社フレアス</li>
                        <li>所在地：〒141-0031 東京都品川区西五反田二丁目27番3号（A-PLACE五反田3F）</li>
                        <li>お問い合わせ先：<a href="<?php echo esc_url( HOME . 'contact/' ); ?>">資料請求・お問い合わせフォーム</a></li>
                    </ol>
                </div>
            </section>
        </div>
        <div class="page-back">
            <a href="<?php echo esc_url( HOME ); ?>" class="link-btn link-btn--submit">
                <span>TOPへ戻る</span>
            </a>
        </div>
    </div>
</section>
<?php
get_template_part( 'template-parts/banner' );
get_footer();
