<?php 

//ログを取るか
ini_set('log_errors','on');

//ログー出力設定

const TEST_MSG = "テスト用メッセージだよ";
const TEST_MSG_ERROR ="テスト用エラー:ユーザー名がありません。";
const MSG_HALF_ERROR = "半角英数字で入力をしてください。";


//エラーメッセージ出力用配列
$err_msg = array();

//文字の入力チェック
function IsNullRequired($value,$key)
{
    if(empty($value))
    {
        global $err_msg;
        $err_msg[$key] = TEST_MSG_ERROR ;
    }
}

//半角英数字チェック
function IsVaildHalfString($value,$key)
{
    var_dump($value);
    //if(!preg_match("/\A\w+\z/",$value))
    if(!ctype_alnum($value))
    {
        global $err_msg;
        var_dump("半角英数字じゃないよ");
        $err_msg[$key] = MSG_HALF_ERROR;
    }
}

function IsVaildSymbol($value,$key)
{
    if(!preg_match("/^[ -]+$/",$value))
    {
        var_dump("記号含まれてます");
    }
}

//Emailか文字列チェック
function IsVaildEmail($value,$key)
{
    if(!preg_match("",$value))
    {
        
    }
}

//文字列の最小チェック
function IsMinStrLen($value,$key,$minlen = 8)
{
    var_dump(strlen($value));
    if(strlen($value) <= $minlen)
    {
        global $err_msg;
        $err_msg[$key] = TEST_MSG_ERROR; 
    }
}

//文字列の最大値チェック
function IsMaxStrLen($value,$key,$maxlen = 15)
{
    if(strlen($value) >= $maxlen)
    {
        global $err_msg;
        $err_msg[$key] = TEST_MSG_ERROR; 
    }
}

//文字列がDBに存在してるかのチェック
function IsEmailDup($value,$key)
{
    global $err_msg;

    try
    {
        $dbh = DBConnect(); 

        $sql = 'SELECT count(*) as Email FROM users WHERE email = :email';
        $sql_date = array(':email' => $email);

        $stmt = queryPost($dbh,$sql,$sql_date);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty(arrya_shift($result)))
        {
            $err_msg['email'] = "";
        }
    }
    catch(Exception $e)
    {
        $err_msg['common'] = 'SQLエラー発生';
    }
}

///////////////////////////////////////////////////////////////////////////////////
//
// DB接続用関数群
//
///////////////////////////////////////////////////////////////////////////////////
//DB接続設定関数
function DBConnect()
{
    $dsn = 'mysql:dbname=bord;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';

    $option= array
    (
        // SQL実行失敗時にはエラーコードのみ設定
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
        // デフォルトフェッチモードを連想配列形式に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    return new PDO($dsn,$user,$password,$option);
}

//クエリ発行用関数
function queryPost($dbh,$sql,$data)
{
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    return $stmt;
}



