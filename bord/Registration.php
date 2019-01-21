<?php

    require('function.php');

    if(!empty($_POST))
    {
        IsVaildHalfString($_POST['password'],'password');

        foreach($_POST as $key => $value)
        {
        //文字入力チェック(全チェック)
            IsNullRequired($value,$key);
        }

        //未入力がある場合は処理を終了する。
        if(!empty($err_msg))
        {
            return;
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $username_key = "username";
        $email_key = "email";
        $password_key = "password";

        //英数字かのチェック
        IsVaildHalfString($username,$username_key);
        IsVaildHalfString($password,$password_key);

        //入力文字の最大長チェック
        IsMaxStrLen($username,$username_key);
        IsMaxStrLen($password,$password_key,30);

        //入力文字の最小長チェック
        IsMinStrLen($password,$password_key);

        //Email形式かのチェック
        IsVaildEmail($email,$email_key);

        //エラーが有る場合はチェック処理を終了する
        if(!empty($err_msg))
        {
            return;
        }

        //IsVaildpassword($_POST['password'],'password');
        //重複したEmailかどうかをチェック
        IsEmailDup($email,$email_key);

        //エラーが有る場合はチェック処理を終了する
        if(!empty($err_msg))
        {
            return;
        }

        //不正入力が無しと判断しDBへ登録
        try
        {
           $dbh = DBConnect(); 

           //クエリ文を作成
           $sql = "INSERT INTO users (username,email,password,login_date,create_date) VALUE (:username ,:email ,:password,:login_date,:create_date)";
           
            $datetime = new DateTime();

           //挿入するデータを配列に格納
           $date = array(
                        ':username'     => $username , 
                        ':email'        => $email ,
                        ':password'     => password_hash($password,PASSWORD_DEFAULT),
                        ':login_date'   => $datetime->format('Y-m-d H:i:s'),
                        ':create_date'  => $datetime->format('Y-m-d H:i:s')
                        );
            
            //クエリ文発行
            $stmt = queryPost($dbh,$sql,$date);

            //クエリ発行が成功/否
            if($stmt)
            {
                //セッションのデフォルト有効期限を一時間とする
                $session_time = 60*60;

                //セッション期限を設定する
                $_SESSION['login_limit'] = $session_time;
                //最終ログインを現在日時に設定する
                $_SESSION['login_date'] = time();
                //ユーザーIDを設定する
                $_SESSION['user_id'] = $dbh->lastInsertId();

                debug('セッション変数の中身:'.print_r($_SESSION,true));

                //マイページへ遷移する
                header("Location:mypage.php");
            }
            else
            {
                error_log('エラー発生', $e->getMessage());
                $err_msg['common'] = 'SQLエラー発生';
            }
        }
        catch(Exception $e)
        {
            error_log('エラー発生', $e->getMessage());
            $err_msg['common'] = 'SQLエラー発生';
        }
    }