<?php

require('DBconnect.php');

header('Content-type : application/json;charset=UTF-8');

if(empty($_POST))
{
    //値が送られてきていないのでエラーを返す
    header('');
}

$thread_id = $_POST['thread_id'];
$response_no = explode(',',$_POST['data']);

try
{
    $pdo = new DBconnect();

    $select = 'ID';
    $from   = 'comment';

    $where = '';

    $count = 1;

    $data = array();

    foreach($response_no as $value)
    {
        if(!empty($where))
        {
            $where =  $where.' OR ';
        }

        $tmp = 'ID = :ID'.$count;

        $data += array(
            ':ID'.$count => $value
        );
        $count += 1;

        $where = $where.$tmp;
    }

    $sql = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where;

    $stmt = $pdo->plural($sql,$data);
    
    $result = $stmt->fetchAll();

    echo json_encode($result);
}
catch(Exception $e)
{
    
}