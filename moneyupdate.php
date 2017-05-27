<?php
include("connect.php");
//應收帳款更新
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
function getToday(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年 
	$month=$today["mon"]; //月
	$day=$today["mday"];  //日
	$year=$year-1911;
	if(strlen($month)=='1')$month='0'.$month;
	if(strlen($day)=='1')$day='0'.$day;
	$today=$year."-".$month."-".$day;
	return $today;
}
$year=$_POST['year'];
$i=0;
foreach($_POST['base_id'] as $value){//墓基編號付款年度
	$base_id[$i]=$value;
	$i++;
}
$i=0;
foreach($_POST['paynumber'] as $value){//墓基編號付款年度
	$paynumber[$i]=$value;
	$i++;
}
$i=0;
foreach($_POST['yeapaid'] as $value){//付款金額
	$yeapaid[$i]=$value;
	$i++;
}
$i=0;
foreach($_POST['notpaid'] as $value){//付款金額
	$notpaid[$i]=$value;
	$i++;
}
$paynumbercount=count($paynumber);
//echo $paynumbercount;
$payday=getToday();//繳費當天日期
for($s=0;$s<$paynumbercount;$s++){
	if(empty($paynumber[$s])!=true){
		if($yeapaid[$s]=='0'){$yeapaid[$s]='-2';}
		if($notpaid[$s]=='0'){$notpaid[$s]='-2';}
		$upsql="update servericespayindex set yeapaid=".$yeapaid[$s].",notpaid=".$notpaid[$s]." where base_id='".$base_id[$s]."' and paynumber=".$paynumber[$s];
		$upres=mysql_query($upsql) or die('Invalid query: ' . mysql_error());
		if($yeapaid[$s]=='-2' and $notpaid[$s]=='-2'){
			$upzerosql="update servericespayindex set yeapaid=0,notpaid=0 where base_id='".$base_id[$s]."' and paynumber=".$paynumber[$s];
			$upzerores=mysql_query($upzerosql) or die('Invalid query: ' . mysql_error());			
		}

	}
}
//寫入資料並顯示提示訊息後回到首頁
/*
$sql="INSERT into price_index(roll_id,price,chineseprice,payday) values ('$roll_id','$price','C','1000-01-01')";
if($sql!=null){
	$res=mysql_query($sql) or die('Invalid query: ' . mysql_error());
}else{
	echo "null";
}
echo $base_id."<br>";
$payyearcount=count($payyear);
$paymoneycount=count($paymoney);
echo $payyearcount."<br>";
echo $paymoneycount."<br>";
echo $payday."<br>";*/
echo '<meta http-equiv=REFRESH CONTENT=5;url=moneyview.php>';
?>