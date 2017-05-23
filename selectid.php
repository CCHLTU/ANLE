<!doctype html>
<!--以墓籍搜尋頁面-->
<html>
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
<body>
	<form action="selectid.php" method="post">		
		<a href="index.html" class="btn btn-primary" role="button"><font size=5>回前頁</font></a>
		<button type="submit" class="btn btn-success"><font size=5>查詢資料</font></button><br>
		<br>
		<br>
		<label><font size=5>墓籍編號：</font></label><input type="text" name="roll_id">
	</form>
	<br>
	<hr>
	<table class="table table-hover">
		<?php
		error_reporting(0);//解決roll_id初始化無值
		header("Content-type: text/html; charset=utf-8");
		include("connect.php");
		$i=0;
		$roll_id=$_POST['roll_id'];
		if($roll_id!=null){
			$sqlpay="select base_id FROM  roll_main where roll_id=$roll_id";
			$resultpay=mysql_query($sqlpay);
			while($rowpay=mysql_fetch_array($resultpay)){
			$newbase=substr($rowpay['base_id'],0,3) ."區" . substr($rowpay['base_id'],4,2) ."號之". substr($rowpay['base_id'],7,2);
			if($i%5 == 0){echo "<tr align=center>";}
			echo "<td><label><form action=selectidview.php method=post><input type=hidden name=base_id value=".$rowpay['base_id']."><button type=submit class=btn btn-success><font size=5>".$newbase."</font></button></label></td>";
			if($i%5 == 6){echo "</tr>";}
			$i++;			
			}
			if($newbase==null)
			{
			echo "<tr align=center><td><label><font size=5>已遷出</font></label></td></tr>";
			}
		
		}
		/*	$sql="select base_id from roll_main where roll_id=".$row['roll_id'];
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$base_id=$row['base_id'];*/
		?>
	</table>
</body>
</html>