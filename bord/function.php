<?php 

//---------------------------------------------
// ログ
//---------------------------------------------
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

//---------------------------------------------
// デバッグ設定
//---------------------------------------------
$debug_flg = true;
function debug($str)
{
    global $debug_flg;
    if(!empty($debug_flg))
    {
        error_log('デバッグ',$str);
    }
}

//---------------------------------------------
// 画面表示処理開始ログ吐き出し関数
//---------------------------------------------
function debuglogstart()
{
    debug('------------------------>画面表示処理開始');
    debug('セッションID:'.session_id());
    debug('セッション変数:' .print_r($_SESSION,true));
    debug('現在日時タイムスタンプ:'.time());
    if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit']))
    {
        debug('ログイン期限日時タイムスタンプ:'.($_SESSION['login_date'] + $_SESSION['login_limit']));
    }
}
//---------------------------------------------
// 定数：注意/警告メッセージ
//---------------------------------------------
//テスト用メッセージ
const TEST_MSG = "TEST:メッセージだよ:TEST";
const TEST_MSG_ERROR ="TEST_ERROR:ユーザー名がありません。:TEST_ERROR";

//本番用メッセージ
const MSG_EMPTY = "入力必須項目です。";
const MSG_EMAIL_ERROR = "Emailの形式で入力してください。";
const MSG_EMAIL_DUP = "すでにEmailアドレスが登録されています。";
const MSG_HALF_ERROR = "半角英数字で入力をしてください。";
const MSG_MIN_LENGTH = "8文字以上で入力してください。";
const MSG_MAX_LENGTH = "255文字以内で入力してください。";

const MSG_CONECT_ERROR = "エラーが発生しました。時間をおいてから再度操作をしてください。";

//---------------------------------------------
//エラーメッセージ出力用配列
//---------------------------------------------
$err_msg = array();

//文字の入力チェック
function IsNullRequired($value,$key)
{
    if(empty($value))
    {
        global $err_msg;
        $err_msg[$key] = MSG_EMPTY ;
    }
}

//---------------------------------------------
//半角英数字チェック
//---------------------------------------------
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

//---------------------------------------------
//半角記号チェック
//---------------------------------------------
function IsVaildSymbol($value,$key)
{
    if(!preg_match("/^[ -]+$/",$value))
    {
        var_dump("記号含まれてます");
    }
}

//---------------------------------------------
//Emailか文字列チェック
//---------------------------------------------
function IsVaildEmail($value,$key)
{
    //if(!preg_match("/\A\w+@\d+\.\d+\z/",$value))
    if(!(bool)filter_var($value,FILTER_VALIDATE_EMAIL))
    {
        global $err_msg;
        $err_msg[$key] = MSG_EMAIL_ERROR; 
    }
}

//---------------------------------------------
//文字列の最小チェック
//---------------------------------------------
function IsMinStrLen($value,$key,$minlen = 8)
{
    var_dump(strlen($value));
    if(strlen($value) <= $minlen)
    {
        global $err_msg;
        $err_msg[$key] = MSG_MIN_LENGTH; 
    }
}

//---------------------------------------------
//文字列の最大値チェック
//---------------------------------------------
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
        //DBの接続設定
        $dbh = DBConnect(); 
        //クエリ文を生成
        $sql = 'SELECT count(*) as Email FROM users WHERE email = :email';
        $sql_date = array(':email' => $email);

         //クエリを発行&取得
        $stmt = queryPost($dbh,$sql,$sql_date);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //結果判定
        //値があれば重複していると判定
        if(!empty(arrya_shift($result)))
        {
            $err_msg[$key] = MSG_EMAIL_DUP;
        }
    }
    catch(Exception $e)
    {
        $err_msg['common'] = MSG_CONECT_ERROR;
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



