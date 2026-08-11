<?php
$dir = '../';
$title = 'Contact【確認】 | Eto';
$description = 'お問い合わせのページです';

// POST送信チェック
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: '.$dir.'contact');
    exit;
}

session_start();
$_SESSION['error'] = [];

// POSTデータをセッションに保存
foreach($_POST as $key => $value){
    $_SESSION[$key] = htmlspecialchars($value, ENT_QUOTES);
}

// 入力チェック関数
function StringsError($key, $label){
    if(mb_strlen($_SESSION[$key]) === 0){
        $_SESSION['error'][] = $label.'を入力してください';
    } else if(preg_match('/　+/', $_SESSION[$key])){
        $_SESSION['error'][] = $label.'が全角スペースのみになっています';
    }
}

StringsError('name','氏名');
StringsError('furigana','フリガナ');
StringsError('mail','メールアドレス');

if($_SESSION['contents'] === '0') $_SESSION['error'][] = 'お問い合わせ内容を選択してください';

if(mb_strlen($_SESSION['memo']) === 0) $_SESSION['error'][] = '備考欄は1文字以上で入力してください';
if(mb_strlen($_SESSION['memo']) > 500) $_SESSION['error'][] = '備考欄は500文字以内で入力してください';

if(!isset($_SESSION['accept'])) $_SESSION['error'][] = '個人情報同意のチェックが押されていません';

// エラーがあればフォームに戻す
if(count($_SESSION['error']) > 0){
    header('Location: '.$dir.'contact');
    exit;
}
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
            --label-color: #555;
            --value-color: #333;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: var(--bg-color);
            color: var(--value-color);
        }

        section.confirm {
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

        p {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        p span:first-child {
            font-weight: bold;
            color: var(--label-color);
        }

        p span:last-child {
            color: var(--value-color);
        }

        .send_btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 30px;
            background-color: var(--main-color);
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .send_btn:hover {
            background-color: var(--main-color-dark);
        }

        @media screen and (max-width: 768px){
            section.confirm {
                margin: 30px 20px;
                padding: 20px;
            }

            p {
                flex-direction: column;
                align-items: flex-start;
            }

            p span:last-child {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <?php include_once $dir.'common/php/navigation.php'; ?>

    <section id="contact" class="confirm">
        <h1 class="title fade_in">Contact<small>【確認画面】</small></h1>
        <p>以下の内容で情報送信します</p>
        <form action="send.php" method="post">
            <p><span>氏名</span><span><?= $_SESSION['name']; ?></span></p>
            <p><span>フリガナ</span><span><?= $_SESSION['furigana']; ?></span></p>
            <p><span>メールアドレス</span><span><?= $_SESSION['mail']; ?></span></p>
            <p><span>お問い合わせ内容</span><span><?= $_SESSION['contents']; ?></span></p>
            <p><span>備考欄</span><span><?= $_SESSION['memo']; ?></span></p>
            <p><span>個人情報同意</span><span><?= $_SESSION['accept']; ?></span></p>
            <p><button type="submit" class="send_btn">送信する</button></p>
        </form>
    </section>

    <?php include_once $dir.'common/php/footer.php'; ?>
</body>
</html>