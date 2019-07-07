<style type="text/css">
	#nav {
    line-height:30px;;
    width:24%;
    float:left;
    padding:5px; 
	}
	#section {
    width:14%;
    float:left;
    padding:10px; 
	}
	#section2 {
    width:14%;
    float:left;
    padding:10px; 
	}
	#section3 {
    width:24%;
    float:left;
    padding:10px; 
	}
	#section5 {
    width:24%;
    float:left;
    padding:10px; 
	}
</style>
<!doctype html>
<!--以墓基搜尋頁面-->
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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<title>墓籍資料</title>
</head>
<body>
	<?php
	error_reporting(0);
	$roll_id=$_POST['roll_id'];
	$rightuser=$_POST['rightuser'];
	$chang=$_POST['chang'];
	if($chang==1){
		echo "<body>
		<form method='post' action='selectid.php' name='aForm'>
		<input type='hidden' name='roll_id' value=".$roll_id.">
		<button type='submit' class='btn btn-primary'><font size='5'>回前頁</font></button>
		</form>
		</body>";
	}else if($chang==2){
		echo "<body>
		<form method='post' action='name.php' name='aForm'>
		<input type='hidden' name='rightuser' value='".$rightuser."'>
		<button type='submit' class='btn btn-primary'><font size='5'>回前頁</font></button>
		</form>
		</body>";
	}
	?>
	<hr>
	<?php
	//墓基資料顯示
		error_reporting(0);//解決roll_id初始化無值
		header("Content-type: text/html; charset=utf-8");
		//$roll_id=$_POST['roll_id'];
		$base_id=$_POST['base_id'];
		include("connect.php");
		if($base_id != null){
			$sql="select roll_main.*,price_index.* FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and roll_main.base_id='".$base_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			if($row != null){
				$newbase=substr($row['base_id'],0,3) ."區" . substr($row['base_id'],4,2) ."號之". substr($row['base_id'],7,2);?>
				<table class="table table-hover">
					<tr>
						<td><font size="4">墓籍編號：<?php echo $row['roll_id'];?></font></td>
						<td><font size="4">墓基編號：<?php echo $newbase;?></font></td></tr>
					<tr>
						<td><font size="4">面　　積：<?php echo $row['area'];?></font></td>
						<td><font size="4">收費標準：<?php echo $row['price'];?></font></td></tr>	
					<tr>
						<td><font size="4">使用權人姓名：<?php echo $row['rightuser'];?></font></td>
						<td><font size="4">使用人姓名：<?php echo $row['username'];?></font></td></tr>
					<tr>
						<td><font size="4">地　　址：<?php echo $row['address'];?></font></td>
						<td><font size="4">電　　話：<?php echo $row['phone'];?></font></td></tr>
					<tr>
						<td><font size="4">關　　係：<?php echo $row['relationship'];?></font></td>
						<td><font size="4">宗　　教：<?php echo $row['faith'];?></font></td></tr>
					<tr>
						<td><font size="4">啟用日期：<?php echo $row['startday'];?></font></td>
						<td><font size="4">存放種類：<?php echo $row['type'];?></font></td></tr>
					<tr>
						<td><font size="4">第二聯絡人：<?php echo $row['rightuser2'];?></td>
						<td><font size="4">電　　話：<?php echo $row['phone2'];?></td></tr>					
					<tr>
						<td><font size="4">地　　址：<?php echo $row['address2'];?></td><td><font size="4">使用序號：<?php echo $row['useingnumber'];?></td></tr>
				</table>
				<form action="marksinput.php" method="post">
					<?php 
						$sqlmark="select * FROM  mark_main where base_id='".$row['base_id']."'";
						$resultmark=mysql_query($sqlmark);
						$rowmark=mysql_fetch_array($resultmark);
						?>
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<label><font size="4">摘要備註</font></label><br>
						<textarea name="remarks" rows="8" cols="200"><?php echo $rowmark['remarks'];?></textarea><br>
						<label><font size="4">收費備註</font></label><br>
						<textarea name="spremarks" rows="8" cols="200"><?php echo $rowmark['spremarks'];?></textarea><br>
						<div align="center"><button type="submit" class="btn btn-success"><font size="5">送出修改內容</font></button>
						</div>
				</form>
				<br><br>
					<div id="nav">
					<form action="payindex.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">修改收費紀錄</font></button>
					</form>
					</div>
					<div id="section">
					<form action="creatrece.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">收據表</font></button>
					</form>
					</div>
					<div id="section2">
					<form action="creatallocation.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">匯款單</font></button>
					</form>
					</div>
					<div id="section3">
					<form action="singledataoutput.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">個人資料卡</font></button>
					</form>		
					</div>
<!--				<div id="section4">
					<form action="siteview.php" method="post">
						<input type="hidden" name="base_id" value=<?php //echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php //echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php //echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">現場圖輸出</font></button>
					</form>		
					</div>-->
					<div id="section5">
					<form action="deletebase_id.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-danger"><font size="5">刪除墓基</font></button>
					</form>		
					</div>		
				<br><br>
				<div align="center">
					<form action="newimg.php" method="post">
						<input type="hidden" name="base_id" value=<?php echo $row['base_id'];?>>
						<input type="hidden" name="back" value=1>
						<input type="hidden" name="chang" value=<?php echo $chang;?>>
						<input type='hidden' name='rightuser' value=<?php echo $rightuser;?>>
						<button type="submit" class="btn btn-success"><font size="5">新增圖片</font></button>
					</form>
				</div>
				<table>
					<?php
					$i=0;
					$imgsql="select * from img_name where base_id='".$base_id."' order by class";
					$imgres=mysql_query($imgsql);
					while($row=mysql_fetch_array($imgres)){
						if($i%5 == 0){
							echo "<tr align=center>";
						}
						//user_pref("capability.policy.localfilelinks.sites", "localhost:8080");file:///
						?>
						<td><img src=img/<?php echo $row['img'];?> height=250px width=250px><br><label><?php echo $row['imgremark'];?></label><br>
						<form action='editimg.php' method='POST'>
						<input name=base_id type=hidden value=<?php echo $base_id; ?>>
						<input name=back type=hidden value=1>
						<input name=img type=hidden value=<?php echo $row['img']; ?>>
						<input name=chang type=hidden value=<?php echo $chang; ?>>
						<input name=rightuser type=hidden value=<?php echo $rightuser; ?>>
						<button type=submit class=btn btn-success><font size=3>修改</font></button></form>

						<form action='delimg.php' method='POST'>
						<input name=base_id type=hidden value=<?php echo $base_id; ?>>
						<input name=img type=hidden value=<?php echo $row['img']; ?>>
						<input name=back type=hidden value=1>
						<input name=chang type=hidden value=<?php echo $chang; ?>>
						<input name=rightuser type=hidden value=<?php echo $rightuser; ?>>
						<button type=submit class=btn btn-success><font size=3>刪除</font></button></form></td>
						<?php
						if($i%5 == 6){
						echo "</tr>";			
						}
						$i++;
					}
					?>
			</table>
		<?php
			}else{
				echo "查無資料";
			}
		}else{
			echo "";
		}
		?>
</body>
</html>