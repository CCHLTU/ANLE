<!--年度收費紀錄-->
<?php
include("connect.php");
$base_id=$_POST['base_id'];
$newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);
?>
<script src="js/mainjs.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<script  src="js/bootstrap.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="http://mybidrobot.allalla.com/jquery/jquery.ui.datepicker-zh-TW.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<h1 align="center"><?php echo $newbase?>收費紀錄</h1>
<form action="payexe.php" method=POST>
<table class="table table-hover">
	<?php
		for($i=0;$i<50;$i++){
			$year=106+$i;
			/*	$sql="select base_id from roll_main where roll_id=".$row['roll_id'];
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$base_id=$row['base_id'];*/
			$sqlpay="select * FROM  pay_index where base_id='".$base_id."' and year like'".$year."%'";
			$resultpay=mysql_query($sqlpay);
			$rowpay=mysql_fetch_array($resultpay);
			echo "<input type=hidden name=base_id value=".$base_id.">";
			if($i%5 == 0){
				echo "<tr align=center>";
			}
			echo "<td><label>".$year."</label><br>";
			echo "<input type=hidden name=outyear[] value=".$year.">";
			echo "<input type=text name=paymoney[] size=5 value=".$rowpay['paymoney']."><br>";
			echo "<label>".$rowpay['payday']."</label></td>";
			if($i%5 == 6){
				echo "</tr>";
			}
			}?>
</table>
<div align="center">
	<button type="submit" class="btn btn-success">確認送出</button>
</div>
</form>	