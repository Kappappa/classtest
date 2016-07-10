<?php
//echo "index.php";
ini_set('display_errors',1);

// class
include_once('./inc/config.php');
include_once('./inc/testClass.php');

try{
  $t1= new testClass();
  $t1->setName("R_fieLd");
  $str1= $t1->getName();
} catch(exception $e) {
  $str1= $e->getMessage();
}
try{
  $t2 = new testClass();
  $t2->setName("123");
  $str2= $t2->getName();
}catch(exception $e){
  $str2= $e->getMessage();
}

echo "<hr>";
echo $str1;   // R_fieLd
echo "<hr>";
echo $str2;   // (・ω・)error

$t1->newsselect(1);

$t1-> shuffleQuestion();

?>
