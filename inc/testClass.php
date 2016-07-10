<?php
class testClass{

  private $name;
  private $pdo;
  private $option;
  private $dsn;

  public function __construct(){
//    echo "construct";
    
    $this->option = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // デフォルトのエラー発生時の処理方法を指定
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      // SELECT 等でデータを取得する際の型を指定
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
      // SELECT した行数を取得する関数 rowCount() が使える
    PDO::ATTR_EMULATE_PREPARES => false,
      // MySQLネイティブのプリペアドステートメント機能の代わりにエミュしたものを使う設定
    PDO::ATTR_STRINGIFY_FETCHES => false
      // 取得時した内容を文字列型に変換するかのオプション,int型も文字列扱い
    );
    $this->dsn = 'mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8';
    try {
      return $this->pdo = new PDO($this->dsn, DB_USER, DB_PASS, $this->option);
      echo 'DBに接続しました';
    } catch (PDOException $e){
//    		echo $e->getMessage();
//    		print("err");
      throw new exception('connect error');
    }
  }
  
  public function newsselect($int){
    if(empty($int)){
      return null;
    }
    $int= intval($int);
    try {
      $this-> pdo-> beginTransaction();
      $sql= 'SELECT * FROM news WHERE lang = :id ORDER BY view_date DESC limit 10;';
      $stmt= $this-> pdo -> prepare($sql);
      $stmt-> bindValue(':id',$int,PDO::PARAM_STR);
      $stmt-> execute();
      $this-> pdo-> commit();
    } catch (Exception $e) {
      $this-> pdo-> rollBack();
      echo "接続に失敗しました。" . $e-> getMessage();
    }
    while($row= $stmt-> fetch(PDO::FETCH_ASSOC)) {
  //    $id = $row["id"];
      $title= $row["title"];
      $view_date= date('Y/m/d', strtotime($row["view_date"]));
      $text= nl2br($row["text"]);
    
echo <<<EOS
		<dt>$view_date</dt>
		<dd>$title : $text</dd>

EOS;
    }

  }
  
  function shuffleQuestion(){
    echo "<hr>";
    for($i=0;$i<10;$i++){
      echo mt_rand(1,50000)."<br>";
    }
  }
  
  public function getName(){
    return $this->name;
  }
  public function setName($name){
    if(false != is_numeric($name)){
      throw new exception('(・ω・)error');
    }
    $this->name = $this->h($name);
  }















  private function h($str,$nl=false){
    htmlspecialchars($str,ENT_QUOTES,"utf-8");
    if($nl) $str=nl2br($str);
    return $str;
  }
}

?>
