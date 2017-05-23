<!doctype html>
<!--遷出頁面-->
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
	<form action="moveout.php" method="post">
		<a href="index.html" class="btn btn-primary" role="button"><font size=5>回前頁</font></a>
		<button type="submit" class="btn btn-success"><font size=5>查詢資料</font></button><br>
		<br>
		<br>
		<label><font size=5>墓基編號：</font></label><input type="text" name="base_idA" size="4" maxlength="3"><font size=5>區</font><input type="text" name="base_idB" size="3" maxlength="2"><font size=5>號之</font><input type="text" name="base_idC" size="3" maxlength="2">
	</form>
	<br>
	<hr>
	<?php
	//墓基資料顯示
		error_reporting(0);//解決roll_id初始化無值
		header("Content-type: text/html; charset=utf-8");
		$base_id=$_POST['base_idA'].'-'.$_POST['base_idB'].'-'.$_POST['base_idC'];
		include("connect.php");
		if($base_id != null){
			$sql="select roll_main.*,price_index.* FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and roll_main.base_id='".$base_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			if($row != null){
				$newbase=substr($row['base_id'],0,3) ."區" . substr($row['base_id'],4,2) ."號之". substr($row['base_id'],7,2);?>
				<table class="table table-hover">
					<tr><td><font size="4">墓籍編號：</font></td><td><font size="4"><?php echo $row['roll_id'];?></font></td><td><font size="4">墓基編號：</font></td><td><font size="4"><?php echo $newbase;?></font></td></tr>
					<tr><td><font size="4">面　　積：</font></td><td><font size="4"><?php echo $row['area'];?></font></td><td><font size="4">收費標準：</font></td><td><font size="4"><?php echo $row['price'];?></font></td></tr>
					<tr><td><font size="4">使用權人姓名：</font></td><td><font size="4"><?php echo $row['rightuser'];?></font></td><td><font size="4">使用人姓名：</font></td><td><font size="4"><?php echo $row['username'];?></font></td></tr>
					<tr><td><font size="4">地　　址：</font></td><td><font size="4"><?php echo $row['address'];?></font></td><td><font size="4">電　　話：</font></td><td><font size="4"><?php echo $row['phone'];?></font></td></tr>
					<tr><td><font size="4">關　　係：</font></td><td><font size="4"><?php echo $row['relationship'];?></font></td><td><font size="4">宗　　教：</font></td><td><font size="4"><?php echo $row['faith'];?></font></td></tr>
					<tr><td><font size="4">啟用日期：</font></td><td><font size="4"><?php echo $row['startday'];?></font></td><td><font size="4">存放種類：</font></td><td><font size="4"><?php echo $row['type'];?></font></td></tr>
				</table>
				<div align="center">
					<?php 
					$sqlmark="select * FROM  mark_main where base_id='".$row['base_id']."'";
					$resultmark=mysql_query($sqlmark);
					$rowmark=mysql_fetch_array($resultmark);
					?>
					<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
					<div style="width:200px;line-height: 50px;padding: 20px;margin-right: 10px;float: left;">
						<label><font size="4">備註</font></label><br>
						<label><font size="4"><?php echo $rowmark['remarks'];?></font></label><br>
					</div>
					<div style="width:500px;line-height: 50px;padding: 20px;float: right;">
						<label><font size="4">特殊備註</font></label><br>
						<label><font size="4"><?php echo $rowmark['spremarks'];?></font></label><br>
					</div>
					<div style="clear:both;"></div>
				</div>
				<br><br>
				<table>
					<?php
					$i=0;
					$imgsql="select * from img_name where base_id='".$base_id."'";
					$imgres=mysql_query($imgsql);
					while($imgrow=mysql_fetch_array($imgres)){
						if($i%5 == 0){
							echo "<tr align=center>";
						}
						echo "<td><img src=img/".$imgrow['img']." height=250px width=250px></td>";
						if($i%5 == 6){
							echo "</tr>";
						}
						$i++;
					}
					?>
				</table>
				<DIV align="center">
					<form action="move_outstart.php" method="post">
						<font size="5">遷出日期：<input type="text" name="moveout"></font><br><br>
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<button type="submit" class="btn btn-success"><font size="5">確定遷出資料</font></button>
					</form>
				</DIV>
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