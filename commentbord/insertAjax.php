<?php
require('DBconnect.php');

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{
    $res_no         = $_POST['last_database_id'];
    $thread_id       = $_POST['thread_id'];
    $username       = $_POST['name'];
    $email          = $_POST['email'];
    $delete_pass    = $_POST['delete_pass'];
    $comment        = $_POST['comment'];
    
    $ipAddres       = $_SERVER['REMOTE_ADDR'];
    try
    {
        $pdo = new DBconnect();

        // $sql = "INSERT INTO comment (
        //             thread_id,
        //             username,
        //             email,
        //             comment,
        //             delete_pass,
        //             ipaddres,
        //             create_data,
        //             update_data )
        //         VALUE (
        //             :thread_id,
        //             :username,
        //             :email,
        //             :comment,
        //             :delete_pass,
        //             :ipaddres,
        //             :create_data,
        //             :update_data
        //             )";
        // $time = new DateTime();
        // $data = array(
        //     ':thread_id'     => $thread_id ,
        //     ':username'     => $username ,
        //     ':email'        => $email ,
        //     ':comment'      => $comment,
        //     ':delete_pass'  => $delete_pass ,//目的が削除のみなのでハッシュ化はしない
        //     ':ipaddres'     => $ipAddres ,
        //     ':create_data'  => $time->format('Y-m-d H:i:s'),
        //     ':update_data'  => $time->format('Y-m-d H:i:s')
        // );

        // $stmt = $pdo->plural($sql,$data);

        // echo json_encode($stmt);
        echo json_encode(true);
        exit;
    }
    catch(Exception $ex)
    {
        //エラーの場合はエラー名を返す
        header("HTTP/1.1 500 Internal Server Error");
       exit;
    }
    
} 