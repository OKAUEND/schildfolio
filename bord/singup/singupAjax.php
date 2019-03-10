<?php

    header("Content-Type: application/json; charset=UTF-8");

    require('../script/function.php');

    if(!empty($_POST))
    {

        $vali_input_flg = $_POST['vali_input'] ? true : false;
        $email = $_POST['email'] ? : null;
        $valid_result_arrya[] = array();

        if(!empty($email))
        {
            $result = VaildEmail($email);
            //入力途中のチェックかの確認
            if($vali_input_flg)
            {
                //emailだけと判断し処理を終了
                echo json_encode($result);
                exit;
            }
            else
            {
                $valid_result_arrya['email'] = $result;
            }
        }
    }

function DBInsert()
{
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