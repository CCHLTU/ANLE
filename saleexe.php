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
$back=$_POST['back'];
$i=0;
foreach($_POST['base_id'] as $value){//墓基編號付款年度
	$base_id[$i]=$value;
	$i++;
}
$i=0;
foreach($_POST['paymoney'] as $value){//付款金額
	$paymoney[$i]=$value;
	$i++;
}
$base_idcount=count($base_id);
$paymoneycount=count($paymoney);
$year=$_POST['year'];//付款年度
$payday=getToday();//繳費當天日期
for($s=0;$s<=$base_idcount;$s++){
	if(empty($paymoney[$s])!='true'){
		$sql="select * from pay_index where base_id='$base_id[$s]' and year='$year'";
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		if(empty($row['base_id'])!='true' and empty($row['year'])!='true'){
			$upsql="update pay_index set paymoney=$paymoney[$s],payday='$payday' where base_id='$base_id[$s]' and year='$year'";
			$upres=mysql_query($upsql) or die('Invalid query: ' . mysql_error());
		}else{
			$rollsql="select roll_id from roll_main where base_id='$base_id[$s]'";
			$rollres=mysql_query($rollsql);
			$rollrow=mysql_fetch_array($rollres);
			echo $rollrow['roll_id'];
			$roll_id=$rollrow['roll_id'];
			$insql="insert into pay_index(roll_id,base_id,year,paymoney,payday) values($roll_id,'$base_id[$s]','$year',$paymoney[$s],'$payday')";
			$inres=mysql_query($insql) or die('Invalid queryinsert: ' . mysql_error());
		}
	}
}
echo $base_id[1]."<br>";
echo $paymoney[1]."<br>";
echo $base_idcount."<br>";
echo $paymoneycount."<br>";
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
echo "銷帳成功";
if($back==1){
	echo '<meta http-equiv=REFRESH CONTENT=3;url=sales.php>';
}else if($back==2){
	echo '<meta http-equiv=REFRESH CONTENT=3;url=Paid.php>';
}else if($back==3){
	echo '<meta http-equiv=REFRESH CONTENT=3;url=unpaid.php>';
}
?>