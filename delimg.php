<?php
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$base_id=$_POST['base_id'];
$img=$_POST['img'];
$delsql="delete from img_name where base_id='".$base_id."' and img='".$img."'";
$res=mysql_query($delsql) or die(mysql_errno());
echo '<meta http-equiv=REFRESH CONTENT=0;url=selectbase.php>';
?>