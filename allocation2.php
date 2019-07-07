<?php
//催收劃撥單
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
$countid="SELECT roll_main.*,price_index.price FROM roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空','已使用','遷出','未使用')) and (roll_main.base_id not in (SELECT B.base_id FROM pay_index B where B.year='".$year."'))";
$countresult=mysql_query($countid);
while($row1=mysql_fetch_array($countresult)){
	if($row1['roll_id'] != 0 and $row1['price'] != 0){
		$countnumber=$countnumber+1;
	}
}
//搜尋條件為去除使用權人為待查及空的資料
$sql="SELECT roll_main.*,price_index.price FROM roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空','已使用','遷出','未使用')) and (roll_main.base_id not in (SELECT B.base_id FROM pay_index B where B.year='".$year."')) order by roll_main.base_id";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
	if($row['roll_id'] != 0 and $row['price'] != 0){
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
	$marksql="select * from mark_main where base_id='".$base_id."'";
	$markresult=mysql_query($marksql);
	$markrow=mysql_fetch_array($markresult);
	$spremarks=$markrow['spremarks'];
	//信封表頭
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(27.0, 20.0);
    $pdf->Write(5, $rightuser, '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(90.0, 20.0);
    $pdf->Write(5, '先生/小姐  啟', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(166.0, 35.0);
    $pdf->Write(1, $roll_id ,'');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $counteraddress=mb_strlen($address,'utf-8');
	if($counteraddress>20){
		$pdf->SetXY(27.0, 35.0);$aa=mb_substr($address,0,20,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(27.0, 40.0);$aa=mb_substr($address,20,$length=null,"utf-8");
		$pdf->Write(1, $aa , '');
	}else{
		$pdf->SetXY(27.0, 35.0);
		$pdf->Write(1, $address, '');
	}
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(162.0, 45.0);
    $pdf->Write(1, $newbase, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(20.0, 55.0);	
    $pdf->Cell(170, 1, '', 'T', 2, 'L', false);
	//輸入內容位置
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(30.0,58.5);
	$pdf->Write(5, '特別備註：'.$spremarks, '');
//	$pdf->Write(5, '請持劃撥單至郵局劃撥若已現場繳費者，本單作廢', '');
//	$pdf->SetXY(30.0,65.5);
//	$pdf->Write(5, '敬請清明節前利用劃撥繳費，避免現場繳費，久候費時', '');
	$pdf->SetXY(30.0, 68.0);
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
	$y=strlen($price);
	$v=137.5;
	for($c=1;$c<=$y;$c++){
		$u=substr($price,$y-$c,1);
		$pdf->SetXY($v, 177.0);
		$pdf->Write(5, $u , '');
		$v=$v-7.5;
	}
$sersql="select * from services";
$serresult=mysql_query($sersql);
$serrow=mysql_fetch_array($serresult);
$y=strlen($serrow['servermoney']);
$v=60.0;
for($c=1;$c<=$y;$c++){
	$u=substr($serrow['servermoney'],$y-$c,1);
	$pdf->SetXY($v, 175.0);
	$pdf->Write(5, $u , '');
	$v=$v-7.5;
}

//$pdf->SetXY(6.0,175.0);$pdf->Write(3,'0 2 4', '');
//$pdf->SetXY(29.0,175.0);$pdf->Write(3,'8 5', '');
//$pdf->SetXY(44.0,175.0);$pdf->Write(3,'8 1 9', '');

$pdf->SetFont('edusongbig5', '', 18, '', true);
$pdf->SetXY(69.0, 187.0);
$pdf->Write(5, $serrow['servername'], '');
	$pdf->SetFont('edusongbig5', '', 10, '', true);
	$pdf->SetXY(6.0, 190.0);
	$pdf->Write(1, '繳款人代號請依序', '');
	$pdf->SetXY(6.0, 195.0);
	$pdf->Write(1, '取下七碼數字', '');
	$pdf->SetFont('edusongbig5', '', 12, '', true);
	$pdf->SetXY(118.0, 196.0);
	$pdf->Write(1, 'V', '');
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(4.0, 200.0);
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
	$pdf->SetXY(0.0,270.5);
	$pdf->Cell(227, 1, '', 'B', 2, 'L', false);
}
}
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($year.'allocation.pdf', 'I');

?>