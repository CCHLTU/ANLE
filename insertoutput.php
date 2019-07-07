<?php
//新增資料
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$roll_id=$_POST['roll_id'];//墓籍編號
if($roll_id == null){$roll_id=0;}
$base_idA=$_POST['base_idA'];$base_idB=$_POST['base_idB'];$base_idC=$_POST['base_idC'];//墓基編號
$area=$_POST['area'];//面積
$moveday=$_POST['moveday'];//面積
if($area == null){$area=0;}
$rightuser=$_POST['rightuser'];//使用權人
if($rightuser == null){$rightuser='';}
$username=$_POST['username'];//使用者
if($username == null){$username='';}
$relationship=$_POST['relationship'];//關係
if($relationship == null){$relationship='';}
$price=$_POST['price'];//收費標準
if($price == null){$price=0;}
$phone=$_POST['phone'];//電話
if($phone == null){$phone='';}
$address=$_POST['address'];//地址
if($address == null){$address='';}
$startday="民國".$_POST['startYY']."年".$_POST['startMM']."月".$_POST['startDD']."日 ".$_POST['startTT'];//啟用日
if($_POST['startYY'] == null){$startday='';}
$type=$_POST['usetype'];//使用種類
$faith=$_POST['faith'];//宗教信仰
//墓基編號對應格式為001-01-00<-->001區01號之00
$base_id=$base_idA ."-". $base_idB ."-".$base_idC;
//寫入資料並顯示提示訊息後回到首頁
$year=date("Y")-1911;
$sql1="INSERT into move_out(roll_id,base_id,area,rightuser,username,relationship,faith,startday,type,phone,address,price,moveday) values ($roll_id,'$base_id',$area,'$rightuser','$username','$relationship','$faith','$startday','$type','$phone','$address',$price,'$moveday')";
if($sql1!=null){
	$res1=mysql_query($sql1)or die('Invalid query: ' . mysql_error());
}else{
	echo "null";
}
//$res2=mysql_query($sql2);
echo "建立成功";
echo '<meta http-equiv=REFRESH CONTENT=5;url=outputview.php>';
?>