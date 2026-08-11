<?php
    $dir = '../';
    //セッションの開始（前のページのスーパーグローバル変数を引き継ぐ）
     session_start();
     /*グローバル変数$_SESSION['name']と$_SESSION['mail']が存在していれば、送信処理をする
     */
     if(isset($_SESSION['name']) === true && isset($_SESSION['mail']) === true){
        //ヒアドキュメント　※EOMの前後にスペースはダメ
        $text_content = <<<EOM
以下の内容で問い合わせがありました。

【氏名】{$_SESSION['name']}
【フリガナ】{$_SESSION['furigana']}
【メールアドレス】{$_SESSION['mail']}
【お問い合わせ内容】{$_SESSION['contents']}
【備考】{$_SESSION['memo']}
【個人情報同意】{$_SESSION['accept']}

============================================
Eto
六本木店
東京都港区六本木2-4-5
営業日：年中無休（年末年始を除く）
営業時間：10:00～20:00
============================================
EOM;
//ヒヤドキュメントの終了「EOM」のインデントによるタブまたはスペースも入れてはいけない
     
        //メール送信の設定
        mb_language('japanese');//言語設定
        mb_internal_encoding('UTF-8');//送信方法の設定

        $to = '07takaishi@gmail.com';//管理者のメールアドレス
        $subject = 'お問い合わせがありました';//件名
        //ヘッダー情報（送信元のメールアドレスの設定で架空のものでもよい）

        $header = 'From: '.mb_encode_mimeheader('Eto').'<info@eto.com>';

        /* 
        メール送信
        mb_send_mail(送信先のアドレス,件名,メール本文,ヘッダー情報);
        ※mb_send_mail()関数は送信できた場合、trueを返す
        */

        if(mb_send_mail($to, $subject, $text_content, $header)) {
            //メール送信が成功した場合の処理
            header('Location: ./thanks.php');
        }else {
            //メール送信が失敗した場合の処理
            echo '<p>メール送信に失敗しました。<br />お電話にてお問合せください</p>';
        }
        

     } else {
        //$_SESSION['name']と$_SESSION['mail']が存在していなかった場合、お問い合わせのページに戻す
        header('Location: '.$dir.'contact');
     }