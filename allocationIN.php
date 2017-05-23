<!doctype html>
<?php
error_reporting(0);
?>
<!--c匯款填入頁面-->
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
<br><br>
	<div style="text-align:center;;width:500px;height:50px;margin:0 auto;">
		<div style="width:300px;height:20px;margin:0 auto;">
			<form action="allocationIN.php" method="post"><input type="text" name="year" id="year"><br><br><button  id="final" type="submit" class="btn btn-primary"><font size="5">年度確認</font></button></form>
			<?php
			$year=$_POST['year'];
			if(empty($year)!=true){
			echo "<script type='text/javascript'>year.style.display='none';final.style.display='none';</script>";
			echo "<label id=yearview><font size=5>選取年度為：".$year."</font></label><br>";
			echo "<form action='allocationIN.php' method='post'>";
			echo "<input type=hidden name=backcheck values=1>";
			echo "<button  id='backto' type='submit' class='btn btn-primary'><font size=5>修改</font></button>";
			echo "</form>";
		}
		$backcheck=$_POST['backcheck'];
		if(empty($backcheck)!=true){
		echo "<script type='text/javascript'>year.style.display='';final.style.display='';backto.style.display='none';yearview.style.display='none';</script>";
	}
	?>
	<form action="merage_allocation.php" method="post">
		<label ><font size="5">訊息內容</font></label>
		<textarea name="IN" rows="20" cols="40"></textarea><br/><br/>
		<?php echo "<input type=hidden name=year values=".$year.">"; ?>
		<a href="index.html" class="btn btn-primary" role="button"><font size="5">回前頁</font></a>
		<button type="submit" class="btn btn-success"><font size="5">送出</font></button>
	</form>
</div>
</div>
</body>
</html>