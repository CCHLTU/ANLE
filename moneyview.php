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
<form action="moneyview.php" method="POST">
	<font size="5">年度</font><input type="text" name="year">
	<button class="btn btn-success" type="submit"><font size="5">送出</font></button>
	<a href="moneyiss.php" class="btn btn-success" role="button"><font size="5">回上頁</font></a>
</form>
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
if(empty($year)!=true){?>
	<div style="text-align:left;width:100%;margin:0 auto;">   
         <div style="text-align:center;width:350px;margin:0 auto;">
         	<h1><?php echo $year."年度應收帳款";?></h1><br>
         </div>
    </div>
<form action="moneyupdate.php" method=POST>
	<table class="table table-hover">
		<tr>
			<td style=height:1%;width:5%; align='left' valign=middle>單據編號</td>
			<td style=height:1%;width:5%; align='left' valign=middle>日期</td>
			<td style=height:1%;width:5%; align='left' valign=middle>收費方式</td>
			<td style=height:1%;width:19%; align='left' valign=middle>摘要</td>
			<td style=height:1%;width:13.5%; align='left' valign=middle>應收金額</td>
			<td style=height:1%;width:13.5%; align='left' valign=middle>實收金額</td>
			<td style=height:1%;width:13.5%; align='left' valign=middle>折扣</td>
			<td style=height:1%;width:13.5%; align='left' valign=middle>未收金額</td>
			<td style=height:1%;width:5%; align='left' valign=middle></td>
		</tr>
		<?php
		$moneysql="select * from servericespayindex where year='$year'";
		$moneyresult=mysql_query($moneysql);
		while ($moneyrow=mysql_fetch_array($moneyresult)) {
			$newbaseryear=substr($moneyrow['base_id'],0,3) ."區" . substr($moneyrow['base_id'],4,2) ."號之". substr($moneyrow['base_id'],7,2);
			echo "<tr><td style=height:1%;width:5%; align='left' valign=middle>".$moneyrow['paynumber']."</td>";
			echo "<td style=height:1%;width:5%; align='left' valign=middle> ". $moneyrow['indate'] ."</td>";
			if($moneyrow['paytype']==1){$moneytype='收據';}if($moneyrow['paytype']==2){$moneytype='匯款單';}
			echo "<td style=height:100%;width:5%; align='left' valign=middle> ". $moneytype ."</td>";
			echo "<td style=height:100%;width:19%; align='left' valign=middle> ". $moneyrow['titleinput'] ."</td>";
			echo "<td style=height:100%;width:13.5%; align='left' valign=middle> ". $moneyrow['paidmoney'] ."</td>";
			echo "<td style=height:100%;width:13.5%; align='left' valign=middle><input type=text name=yeapaid[] size=4 value=".$moneyrow['yeapaid']."></td>";
			echo "<td style=height:100%;width:13.5%; align='left' valign=middle><input type=text name=notpaid[] size=4 value=".$moneyrow['notpaid']."></td>";
			echo "<input type=hidden name=paynumber[] value=".$moneyrow['paynumber'].">";
			echo "<input type=hidden name=base_id[] value=".$moneyrow['base_id'].">";
			$unpaid=$moneyrow['paidmoney']-$moneyrow['yeapaid']-$moneyrow['notpaid'];
			echo "<td style=height:100%;width:13.5%; align='left' valign=middle>".$unpaid."</td>"; 
			echo "<td style=height:100%;width:5%; align='left' valign=middle><form action=deletemoneyview.php method=post><input type=hidden name=delectnumber value=".$moneyrow['paynumber']."><button type=submit class='btn btn-danger'><font size=5>刪除</font></button></form></td></tr>";
		}
		mysql_free_result($result); //釋放記憶
		?>
		</table>
		<button type="submit" class="btn btn-success"><font size="5">送出</font></button>
	</form>
<?php
}
/*
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
}
*/
?>