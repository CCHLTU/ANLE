<?php
include("connect.php");
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
$base_id=$_POST['base_id'];
?>
<form action="newimg.php" method="post" enctype="multipart/form-data">
	圖片<input type="file" name="image" id='image' />
	<input type="hidden" name=base_id value=<?php echo $base_id;?>>
	<legend><button type="submit" class="btn btn-primary">上傳</button></legend>
</form>
<?php
error_reporting(0);
$base_id=$_POST['base_id'];
$insertimg=$_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . iconv('utf-8','big5', $_FILES["image"]["name"]));
if(empty($insertimg)!=true){
	$sql="INSERT INTO img_name(base_id,img) values ('$base_id','$insertimg')";
	$res=mysql_query($sql) or die(mysql_error());
	echo '新增成功'.$insertimg;
	echo '<meta http-equiv=REFRESH CONTENT=3;url=selectbase.php>';
}
?>