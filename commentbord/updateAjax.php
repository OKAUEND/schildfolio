<?

header('Content-Type: application/json; charset=UTF-8');

if(!empty($_POST))
{

    $res_no         = $_POST['res_no'];
    $thread_id       = $_POST['thread_id'];
    
    try
    {
        $dsn = 'mysql:dbname=comment_bord;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';

        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::ATTR_EMULATE_PREPARES => true,
        );

        $dbh = new PDO($dsn,$user,$password,$option);

        $sql = ('SELECT * FROM comment WHERE thread_id = :thread_id AND res_no > :res_no');

        $data = array(
            ':thread_id'     => $thread_id,
            ':res_no'        => $res_no
        );

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!empty(array_shift($result)))
        {

        }
    }
    catch(Exception $ex)
    {

    }
}