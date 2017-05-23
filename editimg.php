<?php
include("connect.php");
header("Content-type: text/html; charset=utf-8");
$base_id=$_POST['base_id'];
$img=$_POST['img'];
?>
<form action="editimg.php" method="post" enctype="multipart/form-data">
	圖片<input type="file" name="image" id='image' />
	<input type="hidden" name=base_id value=<?php echo $base_id;?>>
	<input type="hidden" name=img value=<?php echo $img;?>>
	<legend><button type="submit" class="btn btn-primary">上傳</button></legend>
</form>
<?php
$base_id=$_POST['base_id'];
$img=$_POST['img'];
$editimg=$_FILES['image']['name'];
echo $img."     ".$editimg;
move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . iconv('utf-8','big5', $_FILES["image"]["name"]));
if(empty($editimg)!=true){
	$sql="update img_name set img='".$editimg."' where base_id='".$base_id."' and img='".$img."'";
	$res=mysql_query($sql) or die(mysql_error());
	echo '修改成功';
	echo '<meta http-equiv=REFRESH CONTENT=3;url=selectbase.php>';
}
?>