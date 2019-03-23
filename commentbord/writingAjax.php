<?php

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
    }
    catch(Exception $ex)
    {
       echo 'error' .$ex->getMessage(); 
       die();
    }

    //表示用にDBからレスを取得する
    try
    {
        //SQL文を作成
        $sql = "SELECT * FROM comment";

        $db = new DBconnect();

        $stmt = $db->select($sql);

        $result = $stmt->fetchAll();
        
        echo json_encode($result);
    }
    catch(Exception $ex)
    {
        echo 'error' .$ex->getMessage(); 
        die();
    }
}

class DBconnect{
    const DB_NAME   = 'comment_bord';
    const HOST      = 'localhost';
    const UTF       = 'utf8';
    const USER      = 'root';
    const PASSWORD  = 'root';
    const OPTION    = array(
                            //
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                                PDO::ATTR_EMULATE_PREPARES => true,
                            );
    
    //DBに接続を行う関数
    private function pdo(){
        $dsn = "mysql:dbname=".self::DB_NAME.";host=".self::HOST.";charset=".self::UTF;
        try
        {
            $pdo = new PDO($dsn,self::USER,self::PASSWORD,self::OPTION);
        }
        catch(Exception $e)
        {
            echo 'error' .$e->getMessage;
            die();
        }
        return $pdo;
    }

    function select($sql)
    {
        $tmp = $this->pdo();
        $stmt = $tmp->query($sql);
        return $stmt;
    }

    //SQL文を発行する時に使用する関数
    function plural($sql,$data)
    {
        $tmp = $this->pdo();
        $stmt = $tmp->prepare($sql);
        $result = $stmt->execute($data);
        return $result;
    }
}