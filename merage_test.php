<?php

include("connect.php");
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
$resetsql="delete from merage_receipt";
$resetresult=mysql_query($resetsql);
$i=0;
$sql="SELECT roll_main.*,price_index.price FROM roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空')) ";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	echo $row['roll_id']."<br>";
	$c=0;
	$paysql="select * from pay_index";
	$payresult=mysql_query($paysql);
	while($payrow=mysql_fetch_array($payresult)){
		if($row['base_id']==$payrow['base_id']){
			for($s=0;$s<=count($a);$s++){
				if($row['roll_id']==$a[$s]){
					$roll_id=$row['roll_id'];$base_id=$row['base_id'];$area=$row['area'];$rightuser=$row['rightuser'];$username=$row['username'];$phone=$row['phone'];$address=$row['address'];
					$insertsql="INSERT into merage_receipt(roll_id,base_id,area,rightuser,username,phone,address) values ($roll_id,'$base_id',$area,'$rightuser','$username','$phone','$address')";
					$insertresult=mysql_query($insertsql)or die('Invalid query: ' . mysql_error());
					$c=1;
			//相同資訊但不打入收費	
				}
			}
			if($c==0){
				$a[$i]=$row['roll_id'];
				$totalsql="select roll_id,sum(paymoney) as price from pay_index where roll_id=".$row['roll_id']." group by roll_id;";
				$totalresult=mysql_query($totalsql);
				$totalrow=mysql_fetch_array($totalresult);
				if($totalrow['price']==0){$price=0;}else{$price=$totalrow['price'];}
				$roll_id=$row['roll_id'];$base_id=$row['base_id'];$area=$row['area'];$rightuser=$row['rightuser'];$username=$row['username'];$phone=$row['phone'];$address=$row['address'];
				$insertsql="INSERT into merage_receipt(roll_id,base_id,area,rightuser,username,phone,address,price) values ($roll_id,'$base_id',$area,'$rightuser','$username','$phone','$address',$price)";
				$insertresult=mysql_query($insertsql)or die('Invalid query: ' . mysql_error());
				$i++;
				//首筆相同資訊加入並加總收費
			}
		}
	}
}
echo "<meta http-equiv=REFRESH CONTENT=0;url=choosereceipt.html>";
?>