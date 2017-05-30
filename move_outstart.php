<?php
include("connect.php");
$base_id=$_POST['base_id'];
$moveday=$_POST['moveout'];
$rollsql="select * from roll_main where base_id='".$base_id."'";$rollresult=mysql_query($rollsql);
$pricesql="select * from price_index where base_id='".$base_id."'";$priceresult=mysql_query($pricesql);
$rollrow=mysql_fetch_array($rollresult);
$pricerow=mysql_fetch_array($priceresult);
if(empty($rollrow) != true and empty($pricerow) != true){
	$roll_id=$rollrow['roll_id'];$base_id=$rollrow['base_id'];$area=$rollrow['area'];$rightuser=$rollrow['rightuser'];$username=$rollrow['username'];$relationship=$rollrow['relationship'];$faith=$rollrow['faith'];$startday=$rollrow['startday'];$type=$rollrow['type'];$phone=$rollrow['phone'];$address=$rollrow['address'];$price=$pricerow['price'];
	$insetmoveout="insert into move_out(roll_id,base_id,area,rightuser,username,relationship,faith,startday,type,phone,address,price,moveday) value($roll_id,'$base_id',$area,'$rightuser','$username','$relationship','$faith','$startday','$type','$phone','$address',$price,'$moveday')";
	$insetmoveoutresult=mysql_query($insetmoveout) or die(mysql_error());
	echo $base_id;
	$delroll="delete from roll_main where base_id='".$base_id."'";
	$delrollresult=mysql_query($delroll)or die(mysql_error());
	$delprice="delete from price_index where base_id='".$base_id."'";
	$delpriceresult=mysql_query($delprice)or die(mysql_error());
	$delimg="delete from img_name where base_id='".$base_id."'";
	$delimgresult=mysql_query($delimg)or die(mysql_error());
	$rebase="insert into roll_main(base_id) values('$base_id')";
	$rebaseresult=mysql_query($rebase)or die(mysql_error());
	$reprice="insert into price_index(base_id) values('$base_id')";
	$repriceresult=mysql_query($reprice)or die(mysql_error());
	echo "遷出成功";
	echo "<meta http-equiv=REFRESH CONTENT=3;url=index.html>";
}
?>