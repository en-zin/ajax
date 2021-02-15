<?php

date_default_timezone_set('Asia/Tokyo');


$Fail = 'message.txt';    //ファイルのパスを指定してあげる
$id = uniqid();    //ランダムなIDを生成
$date = date("Y年m月d日 H時i分s秒");    //現在時刻の生成
$title = $_POST['title'];    //titleを引っ張ってくる
$text = $_POST['text'];    //txtを引っ張ってくる
$DATA = [];    //.txtに配列として書き込むための変数
$BOARD = [];    //$DATAを配列の中に封じ込める

$error_message = [];    //エラーメッセージを格納する
$limit_title = 10; //文字数制限
$limit_text = 50;    //文字数制限


//	$ファイルが存在すると起動する
//	Q file_exists json_decode file_get_contentsのそれぞれの役割を考えて
if (file_exists($Fail)) {
    $BOARD = json_decode(file_get_contents($Fail));
}

//文字が多いと起動
if (mb_strlen($title) >= $limit_title)  $error_message[] = 'タイトルは10文字以内でお願いします';
if (mb_strlen($text) >= $limit_text)  $error_message[] = '記事の内容50文字以内でお願いします';

//両方空でなければ起動する
if (!empty($title) && !empty($text)) {

    //配列として＄DATAに格納する
    $DATA = [$id, $title, $text, $date];

    //配列としてしまう
    $BOARD[] = $DATA;

    file_put_contents($Fail, json_encode($BOARD, JSON_UNESCAPED_UNICODE));

    header("Location:" . $_SERVER["SCRIPT_NAME"]);
    exit;
}

?>

<?php foreach (array_reverse($BOARD) as $value) : ?>
    <p><?php echo $value[3] ?></p>
    <p><?php echo $value[1] ?></p>
    <p><?php echo $value[2] ?></p>
    <!-- 独自のURLを発行Details.phpで処理することで?id以降のパラメータを取得する -->
    <p><a href="http://localhost/Task/Details.php/?id=<?php echo $value[0] ?>&title=<?php echo $value[1] ?>&text=<?php echo $value[2] ?>">明細情報</a></p>
<?php endforeach ?>
