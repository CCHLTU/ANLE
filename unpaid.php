<!doctype html>
<!--未繳費頁面-->
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
	<form action="unpaid.php" method="post">

		<a href="index.html" class="btn btn-primary" role="button"><font size="5">回前頁</font></a>
		<button type="submit" class="btn btn-success"><font size="5">查詢資料</font></button><br>
		<br>
		<br>
		<label><font size="5">年度搜尋：</font></label><input type="text" name="$year">
	</form>
	<br>
	<hr>
	<?php
	    error_reporting(0);//解決roll_id初始化無值
	    header("Content-type: text/html; charset=utf-8");
	    $year=$_POST['$year'];
	    include("connect.php");
	    if($year != null){
	    	$sql="select pay_index.*,price_index.price,roll_main.rightuser FROM pay_index inner join(price_index inner join roll_main on roll_main.base_id=price_index.base_id) on pay_index.base_id=roll_main.base_id and pay_index.year='".$year."'";
	    	$result=mysql_query($sql);
	    	$row=mysql_fetch_array($result);
	    	if($row != null){
	    		$newbase=substr($row['base_id'],0,3) ."區" . substr($row['base_id'],4,2) ."號之". substr($row['base_id'],7,2);
	    		echo "<table border=1>";?>
	    		<div style="text-align:left;width:100%;height:100%;margin:0 auto;">   
	    			<div style="text-align:center;width:350px;height:20%;margin:0 auto;">
	    				<h1><?php echo $row['year'];?>年未繳費名冊</h1><br>
	    			</div>
	    		</div>
	    		<table class="table table-hover">
	    			<tr>
	    				<th style="height:100%;width:14%;" align='left' valign="middle"><font size="5">墓籍編號</font></th>
	    				<th style="height:100%;width:20%;" align='left' valign="middle"><font size="5">墓基編號</font></th>
	    				<th style="height:100%;width:28%;" align='left' valign="middle"><font size="5">使用權人</font></th>
	    				<th style="height:100%;width:13.5%;" align='left' valign="middle"><font size="5">費用</font></th>
	    				<th style="height:100%;width:13.5%;" align='left' valign="middle"><font size="5">實繳</font></th>
	    			</tr>
	    		</table>
	    		<form action="saleexe.php" method=POST>
	    			<input type=hidden name=back value=3>
	    			<table class="table table-hover">
	    				<?php
	    				$sqlyear="SELECT roll_main.*,price_index.price FROM roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空'))";
	    				$resultyear=mysql_query($sqlyear);		
	    				while($rowyear=mysql_fetch_array($resultyear)){
	    					$paysql="select * from pay_index where year='".$year."'";
	    					$payresult=mysql_query($paysql);
	    					while($payrow=mysql_fetch_array($payresult)){
	    						if($rowyear['base_id']!=$payrow['base_id']){
	    							$newbaseryear=substr($rowyear['base_id'],0,3) ."區" . substr($rowyear['base_id'],4,2) ."號之". substr($rowyear['base_id'],7,2);
	    							echo "<tr><td style=height:100%;width:14%; align=left valign=middle> ". $rowyear['roll_id'] ."</td>";
	    							echo "<td style=height:100%;width:20%; align=left valign=middle> ". $newbaseryear ."</td>";
	    							echo "<td style=height:100%;width:28%; align=left valign=middle> ". $rowyear['rightuser'] ."</td>";
	    							echo "<td style=height:100%;width:13.5%; align=left valign=middle> ". $rowyear['price'] ."</td>";
	    							echo "<input type=hidden name=year value=".$year.">";
	    							echo "<input type=hidden name=base_id[] value=".$rowyear['base_id'].">";
	    							echo "<td style=height:100%;width:13.5%; align=left valign=middle><input type=text name=paymoney[] size=4 value=".$rowyear['paymoney']."></td></tr>";
	    						} 	    						
	    					}
	    				}
	    				echo "</table>";
				            mysql_free_result($result); //釋放記憶
				        }
				    }else{
				    	echo "查無資料";
				    }
				    ?>
				</table>
				<button type="submit" class="btn btn-success"><font size="5">送出</font></button>
			</form>	
		</body>
		</html>