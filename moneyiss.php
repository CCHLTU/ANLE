<?php
include("connect.php");
?>
<head>
	<meta charset="utf-8">
	<script src="js/mainjs.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<script  src="js/bootstrap.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script type="text/javascript" src="http://mybidrobot.allalla.com/jquery/jquery.ui.datepicker-zh-TW.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<title>ANLE管理</title>
</head>
<form action="moneyiss.php" method="POST">
	<input type="hidden" name="year" value="1">
	<button class="btn btn-success" type="submit"><font size="5">年度收費金額</font></button>
	<a href="creatrece.php" class="btn btn-success" role="button"><font size="5">收據表</font></a>
	<a href="creatallocation.php" class="btn btn-success" role="button"><font size="5">匯款單</font></a>
	<a href="serverice.php" class="btn btn-success" role="button"><font size="5">收入項目整理</font></a>
	<a href="index.html" class="btn btn-success" role="button"><font size="5">回首頁</font></a>
	</form>
<br>
<?php
error_reporting(0);//解決roll_id初始化無值
function getToday(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年 
	$month=$today["mon"]; //月
	$day=$today["mday"];  //日
	$year=$year-1911;
	if(strlen($month)=='1')$month='0'.$month;
	if(strlen($day)=='1')$day='0'.$day;
	$today=$year;
	return $today;
}

$year=$_POST['year'];
$cheakmoney=0;//應收金額
$paidmoney=0;//已收金額
$now=0;
$check=getToday();
if($year==1){
	$sql="select price from price_index";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		if(empty($row['price'])!= true){$now=$row['price'];}else{$now=0;}
		$cheakmoney=$cheakmoney+$now;
	}
	//echo $cheakmoney."<br>";
	$paidsql="select paymoney from pay_index where year='".$check."'";
	$paidresult=mysql_query($paidsql);
	while($paidrow=mysql_fetch_array($paidresult)){
		$paidmoney=$paidmoney+$paidrow['paymoney'];
	}
	//echo $paidmoney."<br>";
	$unpaid=$cheakmoney-$paidmoney;//未收金額
	//echo $unpaid."<br>";
	echo "
	<table class=table table hover>
		<tr><td>年度</td><td>應收金額</td><td>已收金額</td><td>未收金額</td></tr>
		<tr><td>".$check."</td><td>".$cheakmoney."</td><td>".$paidmoney."</td><td>".$unpaid."</td></tr>
	</table>";
}
?>