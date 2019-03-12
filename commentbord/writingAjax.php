<?php

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{
    $res_no         = $_POST['res_no'];
    $thred_id       = $_POST['thred_id'];
    $username       = $_POST['name'];
    $email          = $_POST['email'];
    $delete_pass    = $_POST['delete_pass'];
    $comment        = $_POST['comment'];
    
    $ipAddres       = $_SERVER['REMOTE_ADDR'];

    try
    {
        $dsn = 'mysql:dbname=comment_bord;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';

        $option = array
        (
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::ATTR_EMULATE_PREPARES => true,
        );

        $dbh = new PDO($dsn,$user,$password,$option);

        $sql = "INSERT INTO comment (
                    thread_id,
                    username,
                    email,
                    delete_pass,
                    ipaddres,
                    create_date,
                    update_date )
                VALUE (
                    :res_no,
                    :username,
                    :email,
                    :delete_pass,
                    :ipaddres,
                    :create_date,
                    :update_date
                    )";

        $time = new DateTime();

        $data = array(
            ':res_no'    => $thred_id ,
            ':username'     => $username ,
            ':email'        => $email ,
            ':delete_pass'  => $delete_pass ,//目的が削除のみなのでハッシュ化はしない
            ':ipaddres'     => $ipAddres ,
            ':create_data'  => $time->format('Y-m-d H:i:s'),
            ':update_date'  => $time->format('Y-m-d H:i:s')
        );

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        //データベースへの更新ができなかった時はjsにフラグを返して処理を終了
        if(!$stmt)
        {
            echo $stmt;
            exit;
        }
    }
    catch(Exception $ex)
    {
       echo $ex; 
       exit;
    }

    

}