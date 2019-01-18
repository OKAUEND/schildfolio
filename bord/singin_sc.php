<?php

include("function.php");

debug("|=================================================");
debug("|  ログインページ :ログイン処理");
debug("|=================================================");
debuglogstart();

require('auth.php');

if(!empty($_POST))
{
    debug("入力値有り->POST送信");

    //入力値を変数に格納
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login_save = (!empty($_POST['singin_save'])) ? true : false;

    $email_key = "email";
    $password_key = "password";

    //入力値チェック
    IsNullRequired($email,$email_key);
    IsNullRequired($password,$password_key);

    //最大値チェック
    //IsMaxStrLen($password,$password_key,30);
    //最小値チェック
    //IsMinStrLen($password,$password_key);

    //Email形式チェック
    IsVaildEmail($email,$email_key);

    //英数文字チェック
    IsVaildHalfString($password,$password_key);

    if(!empty($err_msg))
    {
        return;
    }

    debug("バリデーションチェックOK");

    try
    {
        $dbh = DBConnect();

        $sql = "SELECT password,id FROM users WHERE email = :email";
        $sql_date = array('email' => $email);

        $stmt = queryPost($dbh,$sql,$sql_date);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        debug('クエリ結果の中身：'.print_r($result,true));

        if(!empty($result['password']) && password_verify($password,array_shift($result)))
        {
            debug('パスワードが一致');

            //ログイン有効期限(標準を1時間に)
            $session_limit = 60*60;
            
            //最終ログイン日時を現在日時に更新
            $_SESSION['login_date'] = time();

            //ログイン状態保持にチェックがある場合
            if($login_save)
            {
                debug('ログイン保持にチェック');
                $_SESSION['login_limit'] = $session_limit * 24 * 30 ; 
            }
            else
            {
                debug('ログイン保持に未チェック');
                $_SESSION['login_limit'] = $session_limit;
            }
            $_SESSION['user_id'] = $result['id'];

            debug('セッション変数の中身:'.print_r($_SESSION,true));
            debug('マイページへ遷移');
            header('Location:mypage.html');
        }
        else
        {
            debug('パスワードがアンマッチです');
            $err_msg['common'] = "";
        }
    }
    catch(Exception $e)
    {
        error_log('エラー発生'. $e->getMessage());
        $err_msg['common'] = MSG_CONECT_ERROR;
    }
}
debug('<----------------------------------------画面表示終了');