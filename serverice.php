<?php
include("connect.php");
$sql="select * from services";
$sqlresult=mysql_query($sql);
$row=mysql_fetch_array($sqlresult);
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
<script type='text/javascript'>
	function show(obj, id)
	{
		var into=document.getElementById(id);
		if( into.style.display == 'none' )
		{
			view.style.display='none';
			into.style.display='';
		}
	}
</script>
<div id='view'>
	<table  class="table table-condensed"><tr><td>劃撥帳戶：</td><td><?php echo $row['servermoney'];?></td></tr><tr><td>劃撥戶名：</td><td><?php echo $row['servername'];?></td></tr><tr><td>服務電話：</td><td><?php echo $row['serverphone'];?></td></tr><tr><td>服務電話2：</td><td><?php echo $row['serverphone2'];?></td></tr></table>
	<button onclick='show(this, "into")' class="btn btn-danger"><font size="5">修改基本資料</font></button>
	<a href="index.html" class="btn btn-primary" role="button"><font size="5">回首頁</font></a>
</div>

<div id='into' style='display:none'>
	<form method="POST" action="updataserverice.php">
		<table  class="table table-condensed"><tr><td>劃撥帳戶：</td><td><input type=text name=servermoney size=10 value=<?php echo $row['servermoney'];?>></td></tr><tr><td>劃撥戶名：</td><td><input type=text name=servername size=10 value=<?php echo $row['servername'];?>></td></tr><tr><td>服務電話：</td><td><input type=text name=serverphone size=10 value=<?php echo $row['serverphone'];?>></td></tr><tr><td>服務電話2：</td><td><input type=text name=serverphone2 size=10 value=<?php echo $row['serverphone2'];?>></td></tr></table>
		<button type="submit" class="btn btn-danger"><font size="5">確定修改基本資料</font></button>	
	</form>

</div>