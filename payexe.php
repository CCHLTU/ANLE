<?php
//新增資料
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
$base_id=$_POST['base_id'];//墓基編號
$i=0;
foreach($_POST['outyear'] as $value){//付款年度
	$payyear[$i]=$value;
	$i++;
}
$i=0;
foreach($_POST['paymoney'] as $value){//付款金額
	$paymoney[$i]=$value;
	$i++;
}
$payday=getToday();//繳費當天日期
for($s=0;$s<=50;$s++){
	if($paymoney[$s]!=null){
		$sql="select * from pay_index where base_id='$base_id' and year='$payyear[$s]'";
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		if($row!=null){
			$upsql="update pay_index set paymoney=$paymoney[$s],payday='$payday' where base_id='$base_id' and year='$payyear[$s]'";
			$upres=mysql_query($upsql) or die('Invalid query: ' . mysql_error());
		}else{
			$rollsql="select roll_id,base_id from roll_main where base_id='$base_id'";
			$rollres=mysql_query($rollsql);
			$rollrow=mysql_fetch_array($rollres);
			echo $rollrow['roll_id'];
			$roll_id=$rollrow['roll_id'];
			$insql="insert into pay_index(roll_id,base_id,year,paymoney,payday) values (".$roll_id.",'".$base_id."','".$payyear[$s]."',".$paymoney[$s].",'".$payday."')";
			$inres=mysql_query($insql) or die('Invalid query: ' . mysql_error());
			echo "QQ";
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
*/
echo $base_id."<br>";
$payyearcount=count($payyear);
$paymoneycount=count($paymoney);
echo $payyearcount."<br>";
echo $paymoneycount."<br>";
echo $payday."<br>";
echo "建立成功";
echo '<meta http-equiv=REFRESH CONTENT=5;url=index.html>';
?>