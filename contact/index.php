<?php
$dir = '../';
$title = 'Contact | Eto';
$description = 'お問い合わせのページです';
$error_text = '';
session_start();
if(isset($_SESSION['error'])) {
    foreach($_SESSION['error'] as $value){
        $error_text .= '<p>'.$value.'</p>';
    }
    $_SESSION = array();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once $dir.'common/php/meta_head.php'; ?>
    <link rel="stylesheet" href="<?= $dir; ?>common/stylesheet/contact.css" />
    <style>
        :root {
            --main-color: #81d8d0; /* メインカラー */
            --main-color-dark: #4bb3ae; /* ホバー用 */
            --bg-color: #f9f9f9;
            --input-border: #ccc;
            --error-color: #e74c3c;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: var(--bg-color);
            color: #333;
        }

        section#contact {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h1.title {
            color: var(--main-color);
            text-align: center;
            margin-bottom: 40px;
            font-size: 2em;
        }

        form p {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], select, textarea {
            width: 100%;
            padding: 12px 10px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .accept {
            display: flex;
            flex-direction: column;
        }

        .accept label {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .accept small a {
            color: var(--main-color);
            text-decoration: none;
        }

        .accept small a:hover {
            text-decoration: underline;
        }

        .send_btn {
            display: inline-block;
            background-color: var(--main-color);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: 0.3s;
        }

        .send_btn:hover {
            background-color: var(--main-color-dark);
        }

        .error p {
            color: var(--error-color);
            margin: 0 0 10px 0;
        }

        @media screen and (max-width: 768px) {
            section#contact {
                margin: 30px 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include_once $dir.'common/php/navigation.php'; ?>

    <section id="contact">
        <h1 class="title fade_in">Contact</h1>
        <form action="confirm.php" method="post">
            <div class="error">
                <?= $error_text; ?>
            </div>
            <p><input type="text" name="name" placeholder="氏名 例）山田 太郎" /></p>
            <p><input type="text" name="furigana" placeholder="フリガナ 例）ヤマダ タロウ" /></p>
            <p><input type="email" name="mail" placeholder="メールアドレス 例）sample@example.com" /></p>
            <p>
                <select name="contents">
                    <option value="0">選択してください</option>
                    <option value="クリーニング">クリーニングのご依頼</option>
                    <option value="修理">修理のご依頼</option>
                    <option value="サイズ直し">サイズ直しのご依頼</option>
                    <option value="その他">その他のお問い合わせ</option>
                </select>
            </p>
            <p><textarea name="memo" placeholder="こちらに詳しくご記入ください"></textarea></p>
            <p class="accept">
                <label><input type="checkbox" name="accept" value="ok" />個人情報同意</label>
                <small><a href="#">プライバシーポリシー</a>をご確認の上、送信してください。</small>
            </p>
            <p><button type="submit" class="send_btn">確認する</button></p>
        </form>
    </section>

    <?php include_once $dir.'common/php/footer.php'; ?>
</body>
</html>