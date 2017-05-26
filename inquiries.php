<!doctype html>
<!--以墓基搜尋頁面-->
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
	<form action="inquiries.php" method="post">
		
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
		//$roll_id=$_POST['roll_id'];
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
					
				</table>
				<div align="center">
					<form action="marksinput.php" method="post">
						<?php 
						$sqlmark="select * FROM  mark_main where base_id='".$row['base_id']."'";
						$resultmark=mysql_query($sqlmark);
						$rowmark=mysql_fetch_array($resultmark);
						?>
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<div style="width:200px;line-height: 50px;padding: 20px;margin-right: 10px;float: left;">
							<label><font size="4">備註</font></label><br>
							<textarea name="remarks" rows="4" cols="50"><?php echo $rowmark['remarks'];?></textarea><br>
						</div>
						<div style="width:500px;line-height: 50px;padding: 20px;float: right; ">
							<label><font size="4">特殊備註</font></label><br>
							<textarea name="spremarks" rows="4" cols="50"><?php echo $rowmark['spremarks'];?></textarea><br>
						</div>
					</form>
				</div>
				

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