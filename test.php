<?php
//取得今天日期
include("connect.php");
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
function getToday(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年 
	$month=$today["mon"]; //月
	$day=$today["mday"];  //日
 	$year=$year-1911;
	if(strlen($month)=='1')$month='0'.$month;
	if(strlen($day)=='1')$day='0'.$day;
	$today=$year."-".$month."-".$day;
	//echo "今天日期 : ".$today;
 
	return $today;
}
$a=getToday();
echo $a."<br>";

$countnumber=0;
$countid="SELECT * FROM  merage_roll where (roll_id NOT IN (0)) and (price NOT IN ('null'))";
$countresult=mysql_query($countid);
while($row1=mysql_fetch_array($countresult)){
		$countnumber=$countnumber+1;
}
echo $countnumber."<br>";
$roll_id=1005;
	$w=0;
	$viewcount=0;
	$lineout=7;
	$rollsave=null;
	$rollsql="select roll_main.base_id,roll_main.area,price_index.price from roll_main,price_index where roll_main.base_id=price_index.base_id and roll_main.roll_id=".$roll_id;
	$rollresult=mysql_query($rollsql);
	while($rollrow=mysql_fetch_array($rollresult)){
		$zonesql="select * from zone_name where zone_number=".substr($rollrow['base_id'],0,1);
		$zoneresult=mysql_query($zonesql);
		$zonerow=mysql_fetch_array($zoneresult);
		$rollall=$zonerow['zone_chinese'].$rollrow['base_id'].' - '.$rollrow['area'].' - '.$rollrow['price'];
		/*if($rollsave==null){$rollsave=$rollall;}else{
			$rollsave=$rollsave.','.$rollall;
		}*/
		$baseview[$viewcount]=$rollall;
		$viewcount++;
	}
	$countbase=count($baseview);
	for($views=0;$views<$countbase;$views++){
		echo $baseview[$views]."    ";
		$w++;
		if($w==3){echo "<br>";$w=0;}
	}

?>
<fieldset>
<form name="menu" action="test.php" method="post" enctype="multipart/form-data">
圖片<input type="file" name="image" id='image' />
菜單名稱<input type="text" name="base_id" id="base_id" size="6"/>
<legend><button type="submit" class="btn btn-primary">新增</button></legend>
</form></fieldset>
<form name="menu" action="test.php" method="post" enctype="multipart/form-data">
<input type="checkbox" name="allcheck"><label>全部選取</label><br>
				<input type="checkbox" name="hasspace"><label>空白</label><br><button type="submit" class="btn btn-primary">新增</button></form>
<?php
$allcheck=$_POST['allcheck'];
$hasspace=$_POST['hasspace'];
if(empty($hasspace)!=true){echo $hasspace;}else if(empty($allcheck)!=true){echo $allcheck;}
echo $_FILES['image']['error'];
move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . iconv('utf-8','big5', $_FILES["image"]["name"]));
//iconv 上傳中文檔名
echo $aaa;
$aa=is_uploaded_file($_flies['image']['tmp_name']);
echo $aa;
$img=$_FILES['image']['name'];$base_id=$_POST['base_id'];
echo $img."  ".$base_id;
if(empty($img)==null and empty($base_id)==null){
	$sql="INSERT into img_name(base_id,img) values ('$base_id','$img')";
	$res=mysql_query($sql) or die(mysql_error());
	echo '新增成功'.$_FILES['image']['size'];
}else{
	echo 'QQ';
}
	$sql="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空')) order by roll_main.roll_id";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	echo $row."<br>";
?>
<form action="test.php" method="post"><input type="text" name="year" id="year"><button  id="final" type="submit" class="btn btn-primary">新增</button></form>
<?php
$year=$_POST['year'];
if(empty($year)!=true){
	echo "<script type='text/javascript'>year.style.display='none';final.style.display='none';</script>";
	echo "<label id=yearview>".$year."</label>";
	echo "<form action='test.php' method='post'>";
	echo "<inptu type=hidden name=backcheck values=1>";
	echo "<button  id='backto' type='submit' class='btn btn-primary'>修改</button>";
	echo "</form>";
	echo "<inptu type=hidden name=yearout values=".$year.">";
}
$backcheck=$_POST['backcheck'];
if(empty($backcheck)!=true){
	echo "<script type='text/javascript'>year.style.display='';final.style.display='';backto.style.display='none';yearview.style.display='none';</script>";	
}
?>
<script type='text/javascript'>
function show(obj, id)
{
  var o=document.getElementById(id);
  if( o.style.display == 'none' )
  {
    o.style.display='';
    obj.innerHTML='隱藏';
  }
  else
  {
    o.style.display='none';
    obj.innerHTML='顯現';
  }
}
</script>
請用滑鼠點此：
<span onclick='show(this, "box")' style='background:green'>
顯現</span>
<div id='box' style='display:none; background:blue'>
您好！
<p>這塊內容可以隱藏或顯現。
</div>