<?php

require('DBconnect.php');

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{
    $thread_id      = $_POST['thread_id'];
    $last_res_no    = $_POST['last_res_no'];
    $last_res_time  = $_POST['last_res_time'];
    
    $ipAddres       = $_SERVER['REMOTE_ADDR'];
    
    try
    {
        //SQL文を作成
        $sql = "SELECT * FROM comment";

        $db = new DBconnect();

        $stmt = $db->select($sql);

        $list = $stmt->fetchAll();

        foreach($list as $key => $value)
        {
            $list[$key]['username'] = htmlspecialchars($value['username']);
            $list[$key]['email']    = htmlspecialchars($value['email']);
            $list[$key]['comment']  = htmlspecialchars($value['comment']);
        }
        unset($value);
        
        echo json_encode($list);
    }
    catch(Exception $ex)
    {
        echo 'error' .$ex->getMessage(); 
        die();
    }
}