<?php
//發文明細
error_reporting(0);//解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
require_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
// create new PDF document
$i=1;
$countnumber=1;
$allcheck=$_POST['allcheck'];
$notpay=$_POST['notpay'];
$hasspace=$_POST['hasspace'];
$base_idA=$_POST['base_idA'];$base_idB=$_POST['base_idB'];$base_idC=$_POST['base_idC'];
$base_id=$base_idA ."-". $base_idB ."-".$base_idC;
$IN=$_POST['IN'];
$pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);
// ---------------------------------------------------------
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('edusongbig5', '', 20, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$pdf->setHeaderData(false);
$pdf->setPrintFooter(false);
//發文條件
if($allcheck == "on"){
	$countid="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and (rightuser NOT IN ('待查','空'))";
	$countresult=mysql_query($countid);
	while($row1=mysql_fetch_array($countresult)){
		if($row1['roll_id'] != 0 and $row1['price'] != 0){
			$countnumber=$countnumber+1;
		}
	}
	$sql="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id and (roll_main.rightuser NOT IN ('待查','空')) order by roll_main.roll_id";
	$result=mysql_query($sql);
	//全部選取
}else if($notpay == "on"){
	$countid="SELECT roll_id FROM  roll_main";
	$countresult=mysql_query($countid);
	while($row1=mysql_fetch_array($countresult)){
		$countnumber=$countnumber+1;
	}
	$sql="SELECT roll_main.*,price_index.* FROM  roll_main,price_index where roll_main.roll_id=price_index.roll_id";
	$result=mysql_query($sql);
	//未繳費
}else if($base_id== "on"){
	$countid="SELECT roll_id FROM  roll_main where base_id='".$base_id."'";
	$countresult=mysql_query($countid);
	while($row1=mysql_fetch_array($countresult)){
		if($row1['roll_id'] != 0 and $row1['price'] != 0 and $row1['area'] != 0){
			$countnumber=$countnumber+1;
		}
	}
	$sql="SELECT * FROM  roll_main where base_id='".$base_id."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	//墓基編號
}else if($hasspace == "on"){
/*	$session = new Session;
	$session->setData($IN);
	echo '<meta http-equiv=REFRESH CONTENT=0;url=hasspace.php>';*/
	$sql="SELECT * FROM  price_index LIMIT 1";
	$result=mysql_query($sql);
}
while($row=mysql_fetch_array($result)){
	if($row['roll_id'] != 0 and $row['price'] != 0){
		$roll_id=$row['roll_id'];
		$base_id=$row['base_id'];
		$newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);
    //更換格式100-01-00-->100區01號之00
		$address=$row['address'];
		$rightuser=$row['rightuser'];
	//信封表頭
		if($hasspace == "on"){
			$roll_id=" ";$newbase=" ";$address=" ";$rightuser=" ";
			$countnumber=0;
		}
		$pdf->SetFont('edusongbig5', '', 14, '', true);
		$pdf->SetXY(33.0, 15.0);
		$pdf->Write(5, $rightuser, '');
		$pdf->SetXY(90.0, 15.0);
		$pdf->Write(5, '先生/小姐  啟', '');
		$pdf->SetFont('edusongbig5', '', 12, '', true);
		$pdf->SetXY(166.0, 35.0);
		$pdf->Write(1, $roll_id ,'');
		$pdf->SetFont('edusongbig5', '', 14, '', true);
		$pdf->SetXY(33.0, 30.0);
		$pdf->Write(5, $address, '');
		$pdf->SetXY(162.0, 45.0);
		$pdf->Write(1, $newbase, '');
		$pdf->SetXY(10.0, 55.0);
		$pdf->Cell(190, 1, '', 'T', 2, 'L', false);
	//發文內容	
		$pdf->SetFont('edusongbig5', '', 16, '', true);
		$pdf->setxy(10.0,65.0);
//	$pdf->write(1,$IN,12,'');
		$pdf->multicell(195, 1, $IN, 0,'L',0);
		$i++;
		if($i<$countnumber){$pdf->AddPage();}
	}
}
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('issued.pdf', 'I');
?>