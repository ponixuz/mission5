<?php 

 // DB接続設定 
 $dsn = "データベース名"; 
 $user = "ユーザー名"; 
 $password = "パスワード"; 
 $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 

//DB内にテーブルを作成  
			$sql="CREATE TABLE IF NOT EXISTS mm5"
			."("
			."id INT AUTO_INCREMENT PRIMARY KEY,"
			."name char(32),"
			."comment TEXT,"
			."date DATETIME"
			.");";
			$stmt=$pdo->query($sql);

//コメントや名前が入力されててテキストボックスが空の時 
if(isset($_POST["name"])&&isset($_POST["comment"])&&isset($_POST["pass"])&&empty($_POST["txtbox"])&&($_POST["pass"]==123)){
//データ入力（データレコードの挿入） 
 $sql = $pdo -> prepare("INSERT INTO mm5 (name, comment,date) VALUES (:name, :comment,:date)"); 
 $sql -> bindParam(':name', $name, PDO::PARAM_STR); 
 $sql -> bindParam(':comment', $comment, PDO::PARAM_STR); 
 $sql -> bindParam(':date', $date, PDO::PARAM_STR); 
    $name = $_POST["name"]; 
    $comment = $_POST["comment"]; 
    $date=$_POST["date"];
    $date=date("Y/m/d H:i:s");
    $sql -> execute();
}

//編集フォームが送信されたとき 
if(isset($_POST["editNo"])&&isset($_POST["editpass"])&&($_POST["editpass"]==123)){ 
    $edit=$_POST["editNo"]; 
    $editpass=$_POST["editpass"];
//テーブルデータ取得 
    $sql = 'SELECT * FROM mm5';  
    $stmt = $pdo->query($sql); 
    $result = $stmt->fetchAll(); 
//編集選択//ループ開始 
foreach($result as $row){ 
if($row['id']==$edit){
$editnum = $row['id'];
$editname = $row['name'];
$editcom = $row['comment'];
}}} 

//既存の投稿フォームに上記で取得した名前とコメントが入力された状態で表示させる//formで設定 
 
//編集実行//名前とコメントとテキストボックスが入力されているとき 
if(isset($_POST["name"])&&isset($_POST["comment"])&&isset($_POST["txtbox"])&&isset($_POST["pass"])&&($_POST["pass"]==123)){ 
//データレコードの更新 
 $id = $_POST["txtbox"]; //変更する投稿番号 
 $sql = 'UPDATE mm5 SET name=:name,comment=:comment,date=:date WHERE id=:id'; 
 $stmt = $pdo->prepare($sql); 
 $stmt->bindParam(':name', $name, PDO::PARAM_STR); 
 $stmt->bindParam(':comment', $comment, PDO::PARAM_STR); 
 $stmt->bindParam(':date', $date, PDO::PARAM_STR); 
 $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $name = $_POST["name"]; 
    $comment = $_POST["comment"]; 
    $date=$_POST["date"];
    $date=date("Y/m/d H:i:s");
 $stmt->execute();
}

//削除フォームが送信されたとき 
if(isset($_POST["deleteNo"])&&isset($_POST["delpass"])&&($_POST["delpass"]==123)){ 
//データレコードの削除 
 $delete=$_POST["deleteNo"]; 
 $id = $delete; 
 $sql = 'delete from mm5 where id=:id'; 
 $stmt = $pdo->prepare($sql); 
 $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
 $stmt->execute(); }
 
?> 

<!DOCTYPE html> 
<html lang="ja"> 
<head> 
    <meta charset="UTF-8"> 
    <title>m5</title> 
</head> 
     
<body> 
 
<!--名前・コメントを入力するフォーム--> 
    <form action="m_05.php" method="post"> 
        <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)){echo $editname;}?>"> <br> 
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcom)){echo $editcom;}?>"><br> 
        <input type="hidden" name="txtbox"value="<?php if(isset($editnum)){echo $editnum;}?>" ><br> 
        <input type="text" name="pass" placeholder="パスワード"><br> 
        <input type="submit" value="送信"><br> 
         
      <!--削除番号を入力するフォーム--> 
      <form action="m_05.php" method="post"> 
        <input type="text" name="deleteNo" placeholder="削除したい投稿番号"><br> 
        <input type="text" name="delpass" placeholder="パスワード"><br> 
        <input type="submit" name="delete" value="削除"><br> 
        
    <!--編集番号を入力するフォーム--> 
     <form action="m_05.php" method="post"> 
        <input type="text" name="editNo" placeholder="編集したい投稿番号"><br> 
        <input type="text" name="editpass" placeholder="パスワード"><br> 
        <input type="submit" name="edit" value="編集"><br> 
    </form> 

<?php 

 //入力したデータレコードの抽出・表示 
 $sql = 'SELECT * FROM mm5'; 
 $stmt = $pdo->query($sql); 
 $result = $stmt->fetchAll(); 
 foreach ($result as $row){ 
  //$rowの中にはテーブルのカラム名が入る 
    $name = $_POST["name"]; 
    $comment = $_POST["comment"]; 
    $date=$_POST["date"];
    $date=date("Y/m/d H:i:s");
  echo $row['id'].','; 
  echo $row['name'].','; 
  echo $row['comment'].','; 
  echo $row['date'].'<br>'; 
 echo '<hr>';}
 
?>

</body></html>