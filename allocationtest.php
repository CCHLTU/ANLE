<?php
//劃撥單
error_reporting(0);//解決總計預設值
set_time_limit(0);//增加執行時間限制
ini_set('memory_limit', '1024M');//增加記憶體限制
include("connect.php");
header("Content-type: text/html; charset=utf-8");
require_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
$i=1;//紀錄頁數
$countnumber=1;//紀錄資料頁數
$year=$_POST['year'];
$IN=$_POST['IN'];
// create new PDF document
$pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);
// ---------------------------------------------------------
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('edusongbig5', '', 20, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$countid="SELECT * FROM  merage_allocation";
$countresult=mysql_query($countid);
while($row1=mysql_fetch_array($countresult)){
	$countnumber=$countnumber+1;
}
//$countnumber=count(mysql_fetch_array($countresult));
$sql="SELECT * FROM  merage_allocation";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
	if($i<$countnumber){$pdf->AddPage();}//判斷是否為最後一頁 若為是則跳出
	$i++;
	$roll_id=$row['roll_id'];
	$base_id=$row['base_id'];
	$zonesql="select * from zone_name where zone_number=".substr($base_id=$row['base_id'],0,1);
	$zoneresult=mysql_query($zonesql);
	$zonerow=mysql_fetch_array($zoneresult);
	$newbase=$zonerow['zone_chinese'].substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);
    //更換格式100-01-00-->100區01號之00
	$address=$row['address'];
	$rightuser=$row['rightuser'];
	$price=$row['price'];
	//信封表頭
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(30.0,15.0);
	$pdf->Write(5, $rightuser, '');
	$pdf->SetXY(70.0,15.0);
	$pdf->Write(5, '先生/小姐 啟', '');
	$pdf->SetXY(150.0,30.0);
	$pdf->Write(5, $roll_id, '');
	$pdf->SetXY(30.0, 30.0);
	$pdf->Write(5, $address, '');
	$pdf->SetXY(150.0,35.0);
	$pdf->Write(5, $newbase, '');
	$pdf->SetXY(20.0, 40.0);
	$pdf->Cell(180, 1, '', 'T', 2, 'L', false);
	//輸入內容位置
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(30.0,50.5);
	$pdf->Write(5, '請持劃撥單至郵局劃撥若已現場繳費者，本單作廢', '');
	$pdf->SetXY(30.0,58.5);
	$pdf->Write(5, '敬請清明節前利用劃撥繳費，避免現場繳費，久候費時', '');
	$pdf->SetXY(30.0, 70.0);
	$pdf->multicell(180, 1, $IN, 0,'L',0);
	//$pdf->multicell(227, 1, $rollsave, 0,'L',0);
	//沿線撕下
	$pdf->SetXY(0.0,153.5);
	$pdf->Write(5, '請沿此線撕下', '');
	$pdf->SetXY(0.0,157.5);
	$pdf->Cell(227, 1, '', 'B', 2, 'L', false);
	//匯款單圖片 21:11
	$pdf->Image($file='newimg.png',0.0,165,'','','PNG');
	//匯款單內容
	$pdf->SetFont('edusongbig5', '', 21, '', true);
	$pdf->SetXY(6.0,175.0);$pdf->Write(3,'0 2 4', '');
	$pdf->SetXY(29.0,175.0);$pdf->Write(3,'8 5', '');
	$pdf->SetXY(44.0,175.0);$pdf->Write(3,'8 1 9', '');
	$y=strlen($price);
	$v=137.5;
	for($c=1;$c<=$y;$c++){
		$u=substr($price,$y-$c,1);
		$pdf->SetXY($v, 177.0);
		$pdf->Write(5, $u , '');
		$v=$v-7.5;
	}
	$pdf->SetFont('edusongbig5', '', 18, '', true);
	$pdf->SetXY(67.0, 187.0);
	$pdf->Write(5, ' 楊 得 辛', '');
	$pdf->SetFont('edusongbig5', '', 10, '', true);
	$pdf->SetXY(6.0, 190.0);
	$pdf->Write(1, '繳款人代號請依序', '');
	$pdf->SetXY(6.0, 195.0);
	$pdf->Write(1, '取下七碼數字', '');
	$pdf->SetFont('edusongbig5', '', 12, '', true);
	$pdf->SetXY(118.0, 196.0);
	$pdf->Write(1, 'V', '');
	$pdf->SetFont('edusongbig5', '', 18, '', true);
	$pdf->SetXY(6.0, 200.0);
	$pdf->Write(1, $newbase, '');
	$pdf->SetXY(60.0, 203.0);
	$pdf->Write(1, $rightuser, '');
	$pdf->SetFont('edusongbig5', '', 13, '', true);
	$counteraddress=mb_strlen($address,'utf-8');
	if($counteraddress>11 and $counteraddress<=20){
		$pdf->SetXY(60.0, 220.0);$aa=mb_substr($address,0,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(60.0, 225.0);$aa=mb_substr($address,10,$length=null,"utf-8");
		$pdf->Write(1, $aa , '');
	}else if($counteraddress>20){
		$pdf->SetXY(60.0, 220.0);$aa=mb_substr($address,0,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(60.0, 225.0);$aa=mb_substr($address,10,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(60.0, 230.0);$aa=mb_substr($address,20,$length=null,"utf-8");
		$pdf->Write(1, $aa , '');
	}else{
		$pdf->SetXY(60.0, 220.0);
		$pdf->Write(1, $address, '');
	}
}
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($year.'allocation.pdf', 'I');
?>