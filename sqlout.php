<?php
include("connect.php");
//$sql="mysqldump -u root -h 127.0.0.1 -p test > alltable.sql";
//$r=mysql_query($sql)or die(mysql_error());
$insertimg=$_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'],$_FILES["image"]["name"]);
$filename= $insertimg;
$mysql_database="test";
//echo $filename;
	/*if ( !mysql_query ("CREATE DATABASE IF NOT EXISTS `".$mysql_database."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; ") )
	{
		echo '<script type="text/javascript">	alert("建立資料庫失敗"); </script>';
		exit;
	}*/
	mysql_query("TRUNCATE TABLE img_name");
	mysql_query("TRUNCATE TABLE mark_main");
	mysql_query("TRUNCATE TABLE merage_allocation");
	mysql_query("TRUNCATE TABLE merage_receipt");
	mysql_query("TRUNCATE TABLE merage_roll");
	mysql_query("TRUNCATE TABLE move_out");
	mysql_query("TRUNCATE TABLE pay_index");
	mysql_query("TRUNCATE TABLE price_index");
	mysql_query("TRUNCATE TABLE servericespayindex");
	mysql_query("TRUNCATE TABLE services");
	mysql_query("TRUNCATE TABLE zone_name");
	mysql_query("TRUNCATE TABLE roll_main");
	if ( file_exists ($filename) )
	{
		mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
		 
		$templine = '';
		$lines = file($filename);

		foreach ($lines as $line)
		{
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;
		 
			$templine .= $line;
			if (substr(trim($line), -1, 1) == ';')
			{
				mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
				$templine = '';
			}
		}
	}
?>