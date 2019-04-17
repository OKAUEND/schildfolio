<?php

require('DBconnect.php');

header('Content-type : application/json;charset=UTF-8');

if(empty($_POST))
{
    //値が送られてきていないのでエラーを返す
    header('');
}

$thread_id = $_POST['thread_id'];
$response_no = $_POST['data'];

try
{
    $pdo = new DBconnect();

    $select = 'ID';
    $from   = 'comment';

    $where = '';

    $count = 1;

    $data = arrya();

    foreach($response_no as $value)
    {
        if($where.len > 0)
        {
            $where =  $where.'AND ';
        }

        $where = $where.'ID = :ID'.$count;

        $data += array(
            ':ID'.$count => $value
        );
        $count + 1;
    }

    $sql = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where;

    $result = $pdo->plural($sql,$data);
    
}
catch(Exception $e)
{

}