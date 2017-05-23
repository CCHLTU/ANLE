<?php
include("connect.php");
$sql="select * from services";
$sqlresult=mysql_query($sql);
$row=mysql_fetch_array($sqlresult);
$servermoney=$_POST['servermoney'];
$servername=$_POST['servername'];
$serverphone=$_POST['serverphone'];
$serverphone2=$_POST['serverphone2'];
$updatesql="update services set servermoney='$servermoney',servername='$servername',serverphone='$serverphone',serverphone2='$serverphone2' where servermoney='".$row['servermoney']."'";
$updateresult=mysql_query($updatesql) or die(mysql_error());
echo "<meta http-equiv=REFRESH CONTENT=0;url=serverice.php>";
?>