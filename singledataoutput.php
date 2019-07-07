<?php
//個人資料卡輸出
error_reporting(0);//解決總計預設值
set_time_limit(0);//增加執行時間限制
ini_set('memory_limit', '1024M');//增加記憶體限制
include("connect.php");
header("Content-type: text/html; charset=utf-8");
require_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
$base_id=$_POST['base_id'];
$newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);
$chang=$_POST['chang'];
$back=$_POST['back'];
$rightuser=$_POST['rightuser'];
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
$pdf->AddPage();
$sql="SELECT * from roll_main where base_id='$base_id'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);
//更換格式100-01-00-->100區01號之00
$roll_id=$row['roll_id'];
$rightuser=$row['rightuser'];
$address=$row['address'];
$phone=$row['phone'];
$startday=$row['startday'];
$rightuser2=$row['rightuser2'];
$phone2=$row['phone2'];
$address2=$row['address2'];
$username=$row['username'];
$type=$row['type'];
$marksql="select * from mark_main where base_id='$base_id'";
$markresult=mysql_query($marksql);
$markrow=mysql_fetch_array($markresult);
$mark=$markrow['remarks'];
$spremarks=$markrow['spremarks'];

$pdf->SetFont('edusongbig5', '', 16, '', true);
$pdf->SetXY(90.0, 10.0);
$pdf->Write(5, "個人資料卡", '');
$pdf->SetFont('edusongbig5', '', 14, '', true);
$pdf->SetXY(140.0, 15.0);
$pdf->Write(5, $newbase, '');
$pdf->SetXY(30.0, 25.0);
$pdf->Write(5, "墓籍編號：".$roll_id, '');
$pdf->SetXY(30.0, 35.0);
$pdf->Write(5, "使用權人：".$rightuser, '');
$pdf->SetXY(55.0, 40.0);
$pdf->Write(5, $address, '');
$pdf->SetXY(55.0, 45.0);
$pdf->Write(5, $phone, '');
$pdf->SetXY(30.0, 55.0);
$pdf->Write(5, "啟用日期：".$startday, '');
$pdf->SetXY(30.0, 65.0);
$pdf->Write(5, "第二聯絡人：".$rightuser2, '');
$pdf->SetXY(60.0, 70.0);
$pdf->Write(5, $address2, '');
$pdf->SetXY(60.0, 75.0);
$pdf->Write(5, $phone2, '');
$pdf->SetXY(0.0, 80.0);
$pdf->Cell(210, 1, '', 'T', 2, 'L', false);
$pdf->SetXY(30.0, 85.0);
$pdf->Write(5, "使用人：".$username, '');
$pdf->SetXY(30.0, 90.0);
$pdf->Write(5, "使用種類：".$type, '');
$pdf->SetXY(30.0, 95.0);
$pdf->Write(5, "收費備註：".$spremarks, '');
$i=0;$z=0;
$imgsql="select * from img_name where base_id='$base_id' order by class";
$imgresult=mysql_query($imgsql);
while($imgrow=mysql_fetch_array($imgresult)){
    $img=$imgrow['img'];
    $i++;
    $pdf->Image('img/'.$img,20+$z,120,40,40,'JPEG');
    $z+=50;
    if ( $i==3 ){ break;}
}
$pdf->AddPage();
$pdf->SetFont('edusongbig5', '', 16, '', true);
$pdf->SetXY(30.0, 10.0);
$pdf->Write(5, $roll_id, '');
$pdf->SetXY(90.0, 10.0);
$pdf->Write(5, "備註", '');
$pdf->SetXY(160.0, 10.0);
$pdf->Write(5, $newbase, '');
$pdf->MultiCell(180, 1, $mark, $border=0, $align='J', $fill=0, $ln=1, 20.0, 20, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
/*擺放圖
//該墓基資料
$pdf->SetFont('edusongbig5', '', 12, '', true);
$pdf->SetXY(70.0, 10.0+$z);
$pdf->Write(5, "墓基編號：".$newbase, '');
$pdf->SetXY(70.0, 20.0+$z);
$pdf->Write(5, "墓籍編號：".$roll_id, '');
$pdf->SetXY(70.0, 30.0+$z);
$pdf->Write(1, $username ,'');
$pdf->SetXY(70.0, 40.0+$z);
$pdf->Write(1, $mark, '');
*/
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('singledataoutput.pdf', 'I');
?>