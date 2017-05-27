<?php
include("connect.php");
//應收帳款更新
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$deletenumber=$_POST['delectnumber'];
$delectsql="delete from servericespayindex where paynumber=".$deletenumber;
mysql_query($delectsql);
echo '<meta http-equiv=REFRESH CONTENT=5;url=moneyview.php>';
?>