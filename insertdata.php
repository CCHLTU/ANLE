<?php
//新增資料
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$roll_id=$_POST['roll_id'];//墓籍編號
$base_idA=$_POST['base_idA'];$base_idB=$_POST['base_idB'];$base_idC=$_POST['base_idC'];//墓基編號
$zone_number=$_POST['zone_number'];//區碼
$area=$_POST['area'];//面積
$rightuser=$_POST['rightuser'];//使用權人
$username=$_POST['username'];//使用者
$relationship=$_POST['relationship'];//關係
$price=$_POST['price'];//收費標準
$phone=$_POST['phone'];//電話
$address=$_POST['address'];//地址
$startday=$_POST['startday'];//啟用日
$type=$_POST['usetype'];//使用種類
$faith=$_POST['faith'];//宗教信仰
$rightuser2=$_POST['rightuser2'];//第二聯絡人
$phone2=$_POST['phone2'];//第二聯絡人電話
$address2=$_POST['address2'];//第二聯絡人地址
//墓基編號對應格式為001-01-00<-->001區01號之00
$base_id=$base_idA ."-". $base_idB ."-".$base_idC;

if($roll_id==null){
	 echo '<script>alert("未填寫墓籍編號");window.history.go(-1);</script>';exit;
	 }

/*確認該筆是否編號已使用
$check="SELECT * FROM roll_main WHERE roll_id='$roll_id'";
$result_check=mysql_query($check);
$has=mysql_num_rows($result_check);

if($has==1){
	echo '<script>alert("該墓籍編號已存在");window.histiry.go(-1);</script>';	exit;
	}
*/
//寫入資料並顯示提示訊息後回到首頁
$year=date("Y")-1911;
echo $year."<br>";
$usernumber="select useingnumber from roll_main where useingnumber like '".$year."___' order by useingnumber";
$userres=mysql_query($usernumber);
while ($row=mysql_fetch_array($userres)) {
	$usenumber=$row['useingnumber'];
	echo $usenumber."<br>";
}

if(empty($usenumber) == true){
	$usenumber=$year."001";
}else{
	$usenumber++;
}
$sql1="INSERT into roll_main(useingnumber,roll_id,base_id,zone_number,area,rightuser,username,relationship,faith,startday,type,phone,address,rightuser2,phone2,address2) values ($usenumber,$roll_id,'$base_id','$zone_number',$area,'$rightuser','$username','$relationship','$faith','$startday','$type','$phone','$address','$rightuser2','$phone2','$address2')";
if($sql1!=null){
	$res1=mysql_query($sql1)or die('Invalid query: ' . mysql_error());
}else{
	echo "null";
}

$sql2="INSERT into price_index(roll_id,price,base_id) values ($roll_id,'$price','$base_id')";
if($sql2!=null){
	$res2=mysql_query($sql2) or die('Invalid query: ' . mysql_error());
}else{
	echo "null";
}

//$res2=mysql_query($sql2);
echo "建立成功";
echo '<meta http-equiv=REFRESH CONTENT=5;url=index.html>';
?>