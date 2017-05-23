<?php
//新增資料
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$base_id=$_POST['base_id'];//墓基編號
$remarks=$_POST['remarks'];//備註
$spremarks=$_POST['spremarks'];//特殊備註
//寫入資料並顯示提示訊息後回到首頁

$check="SELECT * FROM mark_main WHERE base_id='".$base_id."'";
$result_check=mysql_query($check);
$has=mysql_num_rows($result_check);

if($has==null){
	$sql="INSERT into mark_main(base_id,remarks,spremarks) values ('$base_id','$remarks','$spremarks')";
}else if($has!=null){
	if($remarks != null and $spremarks != null)
	{
		$sql="update mark_main set remarks='$remarks',spremarks='$spremarks' where base_id='$base_id'";
	}else if($remarks != null){
		$sql="update mark_main set remarks='$remarks' where base_id='$base_id'";
	}else if($spremarks != null){
		$sql="update mark_main set spremarks='$spremarks' where base_id='$base_id'";
	}
	
}else{
	echo "動作";
}
$res=mysql_query($sql)or die('Invalid query: ' . mysql_error());
echo "寫入成功";
echo '<meta http-equiv=REFRESH CONTENT=3;url=selectid.php>';
?>