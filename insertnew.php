<?php include("connect.php");header("Content-type: text/html; charset=utf-8"); ?>
<!doctype html>
<!--新增墓籍資料頁面-->
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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
	<title>新增墓籍資料</title>
</head>
<body>
		<a href="index.html" class="btn btn-primary" role="button" ><font size="5">回前頁</font></a>
		<button type="submit" class="btn btn-success"><font size="5">新增資料</font></button>
	<form action="insertdata.php" method="post">
		<table border="0" style="width:80%;" class="table table-striped" align="center">
			<colgroup>
      			<col style="width:20%">
      			<col style="width:30%">
      			<col style="width:20%">
      			<col style="width:30%">
	  		</colgroup>
			<tr>
			<td><font size="4">墓籍編號</font></tb><td><input type="text" name="roll_id" size="10"></td>
			<td><font size="4">墓基編號</font></td><td><input type="text" name="base_idA" size="4" maxlength="3"><font size="4">區</font><input type="text" name="base_idB" size="3" maxlength="2"><font size="4">號之</font><input type="text" name="base_idC" size="3" maxlength="2"></td></tr>
			<tr>
			<td><font size="4">區碼</font></tb><td><input type="text" name="zone_number" size="10"></td>
			<td><font size="4">面積</font></td><td><input type="text" name="area" size="10"></td>
			</tr>
			<tr>
			<td><font size="4">使用權人姓名</font></tb><td><input type="text" name="rightuser" size="10"></td>
			<td><font size="4">使用人姓名</font></td><td><input type="text" name="username" size="10"></td></tr>
			<tr>
			<td><font size="4">關係</font></tb><td><input type="text" name="relationship" size="10"></td>
			<td><font size="4">收費標準</font></td><td><input type="text" name="price" size="10"></td></tr>
			<tr>
			<td><font size="4">電話</font></tb><td><input type="text" name="phone" size="10"></td></tr>
			<tr>
			<td><font size="4">地址</font></tb><td><input type="text" name="address" size="25"></td><td><pre><font size="4">範例：407台中市南屯區嶺東路1號</font></pre></td><td></td></tr>
			<tr>
			<td><font size="4">啟用日期</font></tb><td><input type="text" name="startday" size="25"></td><td><pre><font size="4">範例：民國88年08月08日 辰</font></pre></td><td></td></tr>
			<tr>
			<td><font size="4">宗教信仰</font></tb><td><input type="text" name="faith" size="10"></td>
			<td><font size="4">存放方式</font></td><td><select name="usetype"><option value="大體"><font size="4">大體</font><option value="骨骸"><font size="4">骨骸</font><option value="骨灰"><font size="4">骨灰</font><option value="其他"><font size="4">其他</font></select></td></tr>
		</table>

	</form>
</body>
</html>