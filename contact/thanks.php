<?php
$dir = '../';
$title = 'Contact【送信完了】 | Eto';
$description = 'お問い合わせのページです';

session_start();
$_SESSION = array(); // セッションの初期化
session_destroy();   // セッションの破棄
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once $dir.'common/php/meta_head.php'; ?>
    <link rel="stylesheet" href="<?= $dir; ?>common/stylesheet/contact.css" />
    <style>
        :root {
            --main-color: #81d8d0;
            --main-color-dark: #4bb3ae;
            --bg-color: #f9f9f9;
            --text-color: #333;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        section.thanks {
            max-width: 600px;
            margin: 60px auto;
            padding: 40px 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1.title {
            color: var(--main-color);
            font-size: 2em;
            margin-bottom: 30px;
        }

        .box_wrap p {
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .send_btn {
            display: inline-block;
            padding: 12px 40px;
            font-size: 1em;
            color: #fff;
            background-color: var(--main-color);
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .send_btn:hover {
            background-color: var(--main-color-dark);
        }

        @media screen and (max-width: 768px){
            section.thanks {
                margin: 30px 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <?php include_once $dir.'common/php/navigation.php'; ?>

    <section id="contact" class="thanks">
        <h1 class="title fade_in">Contact【送信完了】</h1>
        <div class="box_wrap">
            <p>
                お問い合わせありがとうございます。<br />
                内容確認後、担当者より折り返しご連絡いたします。
            </p>
            <p><a href="<?= $dir; ?>" class="send_btn">TOPへ戻る</a></p>
        </div>
    </section>

    <?php include_once $dir.'common/php/footer.php'; ?>
</body>
</html>