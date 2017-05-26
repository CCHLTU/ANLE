<?php
include("connect.php");
?>
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
<form action="moneyallcation.php" method="POST">
	<table class="table table-condensed">
		<tr><td><font size="5">墓基號碼</font><input type="text" name="base_idA" size="4" maxlength="3"><font size=5>區</font><input type="text" name="base_idB" size="3" maxlength="2"><font size=5>號之</font><input type="text" name="base_idC" size="3" maxlength="2"></td><td></td></tr>
		<tr><td><font size="5">主旨</font><input type="text" name="titleinput"></td><td><font size="5">說明</font><input type="text" name="textinput"></td></tr>
		<tr><td><font size="5">明細</font></td><td><font size="5">應收金額</font></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
		<tr><td><input type="text" name="textall[]"></td><td><input type="text" name="moneyall[]"></td></tr>
	</table>
	<button class="btn btn-success" type="submit"><font size="5">送出</font></button>
	<a href="moneyiss.php" class="btn btn-success" role="button"><font size="5">回上頁</font></a>
</form>
