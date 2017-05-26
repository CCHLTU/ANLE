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
$IN=$_POST['IN'];
// create new PDF document
$pdf = new TCPDF('P','mm','A3', true, 'UTF-8', false);
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
$countid="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空'))";
$countresult=mysql_query($countid);
while($row1=mysql_fetch_array($countresult)){
	if($row1['roll_id'] != 0 and $row1['price'] != 0 and $row1['area'] != 0){
		$countnumber=$countnumber+1;
	}
}
//$countnumber=count(mysql_fetch_array($countresult));
$sql="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空'))";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
	if($row['roll_id'] != 0 and $row['price'] != 0 and $row['area'] != 0){
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
	$pdf->SetXY(70.0,55.0);
	$pdf->Write(5, $rightuser, '');
	$pdf->SetXY(120.0,55.0);
	$pdf->Write(5, '先生/小姐 啟', '');
	$pdf->SetXY(210.0,75.0);
	$pdf->Write(5, $roll_id, '');
	$pdf->SetXY(70.0, 70.0);
	$pdf->Write(5, $address, '');
	$pdf->SetXY(185.0,90.0);
	$pdf->Write(5, $newbase, '');
	$pdf->SetXY(45.0, 110.0);
	$pdf->Cell(210, 1, '', 'T', 2, 'L', false);
	//輸入內容位置
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(55.0,115.5);
	$pdf->Write(5, '請持劃撥單至郵局劃撥若已現場繳費者，本單作廢', '');
	$pdf->SetXY(55.0,125.5);
	$pdf->Write(5, '敬請清明節前利用劃撥繳費，避免現場繳費，久候費時', '');
	$pdf->SetXY(55.0, 135.0);
	$pdf->multicell(227, 1, $IN, 0,'L',0);
	//沿線撕下
	$pdf->SetXY(35.0,247.5);
	$pdf->Write(5, '請沿此線撕下', '');
	$pdf->SetXY(35.0,248.5);
	$pdf->Cell(227, 1, '', 'B', 2, 'L', false);
	//匯款單圖片
	$pdf->Image($file='allocation1.png',35.0,255.5,227,110,'PNG');
	//匯款單內容
	$pdf->SetFont('edusongbig5', '', 21, '', true);
	$pdf->SetXY(42.0,265.0);$pdf->Write(3,'0 2 4', '');
	$pdf->SetXY(66.0,265.0);$pdf->Write(3,'8 5', '');
	$pdf->SetXY(83.0,265.0);$pdf->Write(3,'8 9 1', '');
	$y=strlen($price);
	$v=182.5;
	for($c=1;$c<=$y;$c++){
		$u=substr($price,$y-$c,1);
		$pdf->SetXY($v, 266.0);
		$pdf->Write(5, $u , '');
		$v=$v-7.5;
	}
	$pdf->SetFont('edusongbig5', '', 18, '', true);
	$pdf->SetXY(111.0, 277.0);
	$pdf->Write(5, ' 楊 得 辛', '');
	$pdf->SetFont('edusongbig5', '', 10, '', true);
	$pdf->SetXY(40.0, 285.0);
	$pdf->Write(1, '繳款人代號請依序', '');
	$pdf->SetXY(40.0, 290.0);
	$pdf->Write(1, '取下七碼數字', '');
	$pdf->SetFont('edusongbig5', '', 12, '', true);
	$pdf->SetXY(139.0, 286.0);
	$pdf->Write(1, 'V', '');
	$pdf->SetFont('edusongbig5', '', 16, '', true);
	$pdf->SetXY(40.0, 295.0);
	$pdf->Write(1, $newbase, '');
	$pdf->SetXY(103.0, 292.0);
	$pdf->Write(1, $rightuser, '');
	$pdf->SetFont('edusongbig5', '', 13, '', true);
	$counteraddress=mb_strlen($address,'utf-8');
	if($counteraddress>11 and $counteraddress<=20){
		$pdf->SetXY(100.0, 310.0);$aa=mb_substr($address,0,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(100.0, 315.0);$aa=mb_substr($address,10,$length=null,"utf-8");
		$pdf->Write(1, $aa , '');
	}else if($counteraddress>20){
		$pdf->SetXY(100.0, 310.0);$aa=mb_substr($address,0,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(100.0, 315.0);$aa=mb_substr($address,10,10,"utf-8");
		$pdf->Write(1, $aa, '');
		$pdf->SetXY(100.0, 320.0);$aa=mb_substr($address,20,$length=null,"utf-8");
		$pdf->Write(1, $aa , '');
	}else{
		$pdf->SetXY(100.0, 310.0);
		$pdf->Write(1, $address, '');
	}
}
}
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('allocation.pdf', 'I');
?>