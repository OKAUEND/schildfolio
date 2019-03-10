<?php

//---------------------------------------------
// ログイン認証
//---------------------------------------------
//ログインしている場合
if(!empty($_SESSION['login_date']))
{
    debug("ログイン済みユーザーです");
    // 自動ログアウト認証
    if(($_SESSION['login_date'] + $_SESSION['login_limit']) < time())
    {
        debug('ログイン期限切れユーザーです');
        //セッションを削除しログアウトとする
        session_destroy();
        //ログインページへ遷移
        header("Location:login.php");
    }
    else
    {
        debug('ログイン期限内ユーザーです');
        //セッション日時を更新する
        $_SESSION['login_date'] = time();

        //現在ページを確認し、ログインページ以外なら遷移処理を行わない
        if(basename($_SERVER['PHP_SELF']) === 'login.php')
        {
            debug('マイページへ遷移します');
            header("Location:mypage.html");
        }
    }
}
else
{
    debug("未ログインユーザーです");
}
