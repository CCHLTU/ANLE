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
	<form action="testany.php" method="post">
		<label>墓籍編號：</label><input type="text" name="roll_id"><br>
		<a href="index.html" class="btn btn-primary" role="button">回前頁</a>
		<button type="submit" class="btn btn-success">查詢資料</button>
	</form>
	<br>
	<hr>
	<?php
	//墓籍資料顯示
		error_reporting(0);//解決roll_id初始化無值
		header("Content-type: text/html; charset=utf-8");
		$roll_id=$_POST['roll_id'];
		include("connect.php");
		if($roll_id != null){
			$sql="select roll_main.*,price_index.* FROM  roll_main,price_index where roll_main.roll_id=price_index.roll_id and roll_main.roll_id=".$roll_id;
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			if($row != null){
				$newbase=substr($row['base_id'],0,3) ."區" . substr($row['base_id'],4,2) ."號之". substr($row['base_id'],7,2);?>
				<table class="table table-hover">
				<tr><td>墓籍編號：</td><td><?php echo $row['roll_id'];?></td><td>墓基編號：</td><td><?php echo $newbase;?></td></tr>
				<tr><td>面　　積：</td><td><?php echo $row['area'];?></td><td>收費標準：</td><td><?php echo $row['price'];?></td></tr>
				<tr><td>使用權人姓名：</td><td><?php echo $row['rightuser'];?></td><td>使用人姓名：</td><td><?php echo $row['username'];?></td></tr>
				<tr><td>地　　址：</td><td><?php echo $row['address'];?></td><td>電　　話：</td><td><?php echo $row['phone'];?></td></tr>
				<tr><td>關　　係：</td><td><?php echo $row['relationship'];?></td><td>宗　　教：</td><td><?php echo $row['faith'];?></td></tr>
				<tr><td>啟用日期：</td><td><?php echo $row['startday'];?></td><td>存放種類：</td><td><?php echo $row['type'];?></td></tr>
				</table>
				<!--年度收費紀錄-->
				<form action="payexe.php" method=POST>
				<table class="table table-hover">
				<?php
				for($i=0;$i<50;$i++)
				{
					$year=106+$i;
					$sql="select base_id from roll_main where roll_id=".$roll_id;
					$result=mysql_query($sql);
					$row=mysql_fetch_array($result);
					$base_id=$row['base_id'];
					$sqlpay="select * FROM  pay_index where base_id='".$base_id."' and year like'".$year."%'";
					$resultpay=mysql_query($sqlpay);
					$rowpay=mysql_fetch_array($resultpay);
					echo "<input type=hidden name=base_id value=".$base_id.">";		
					if($i%5 == 0){
						echo "<tr align=center>";
					}
					echo "<td><label>".$year."</label><br>";

					echo "<input type=text name=paymoney[] size=5 value=".$rowpay['paymoney']."><br>";
					echo "<label>".$rowpay['payday']."</label></td>";
					if($i%5 == 6){
						echo "</tr>";
					}
				}?>
				</table>
				<button type="submit" class="btn btn-success">送出</button>
				</form>	
			<?php
			}else{
				echo "查無資料";
			}
		}else{
			echo "";
		}
	?>
</body>
</html>