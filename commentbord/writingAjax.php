<?php

require('DBconnect.php');

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{
    $res_no         = $_POST['res_no'];
    $thread_id      = $_POST['thread_id'];
    $username       = $_POST['name'];
    $email          = $_POST['email'];
    $delete_pass    = $_POST['delete_pass'];
    $comment        = $_POST['comment'];
    
    $ipAddres       = $_SERVER['REMOTE_ADDR'];

    try
    {
        //SQL文を作成
        $sql = "INSERT INTO comment (
                    thread_id,
                    username,
                    email,
                    comment,
                    delete_pass,
                    ipaddres,
                    create_data,
                    update_data )
                VALUE (
                    :thread_id,
                    :username,
                    :email,
                    :comment,
                    :delete_pass,
                    :ipaddres,
                    :create_data,
                    :update_data
                    )";

        //現在の時刻を取得
        $time = new DateTime();

        //DBへ格納する値を配列に格納
        $data = array(
            ':thread_id'    => $thread_id ,
            ':username'     => $username ,
            ':email'        => $email ,
            ':comment'      => $comment,
            ':delete_pass'  => $delete_pass ,
            ':ipaddres'     => $ipAddres ,
            ':create_data'  => $time->format('Y-m-d H:i:s'),
            ':update_data'  => $time->format('Y-m-d H:i:s')
        );

        //DBを設定
        $db = new DBconnect();
        //DBへ格納する
        $stmt = $db->plural($sql,$data);

        //データベースへの更新ができなかった時はjsにフラグを返して処理を終了
        if(!$stmt)
        {
            echo 'error';
            die();
        }

        echo json_encode(true);
    }
    catch(Exception $ex)
    {
       echo 'error' .$ex->getMessage(); 
       die();
    }
}
