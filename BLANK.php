<?php
//空白收據表
//error_reporting(0);解決總計預設值
set_time_limit(0);//增加執行時間限制
ini_set('memory_limit', '1024M');//增加記憶體限制
include("connect.php");
header("Content-type: text/html; charset=utf-8");
require_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
// create new PDF document
$pdf = new TCPDF('P','mm','A4', true, 'UTF-8', false);
// ---------------------------------------------------------
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('edusongbig5', '', 20, '', true);
$pdf->AddPage();
// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
function getToday(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年
	$year=$year-1911;
	return $year;
}
function nextyear(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年
	$year=$year-1910;
	return $year;
}
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

	//信封表頭 輸出時除去空墓位
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(27.0, 20.0);
    $pdf->Write(5, ' ', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(90.0, 20.0);
    $pdf->Write(5, '先生/小姐  啟', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(166.0, 35.0);
    $pdf->Write(1, ' ' ,'');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(27.0, 35.0);
    $pdf->Write(5, ' ', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(162.0, 45.0);
    $pdf->Write(1, ' ', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(20.0, 55.0);	
    $pdf->Cell(170, 1, '', 'T', 2, 'L', false);
	//存根聯
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 65.0);
    $pdf->Write(5, '存', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 64.0);
    $pdf->Write(5, '墓籍編號：'. ' ', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(105.0, 64.0);
    $pdf->Write(5, '墓基編號：' . '     區     號之', '');	
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(160.0, 80.0);
    $pdf->Write(5, '面積：' . ' ', '');
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 75.0);
    $pdf->Write(5, '根', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 80.0);
    $pdf->Write(5, '使用權人：' . ' ', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(105.0, 80.0);
    $pdf->Write(5, '費用：' . ' ', '');
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 85.0);
    $pdf->Write(5, '聯', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 90.0);
    $pdf->Write(5, '起訖日期：', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(62.0, 89.0);
    $year=getToday();
    $pdf->Write(5, '民國 '.$year.' 年 4 月 5 日起', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(62.0, 94.0);
    $nextyear=nextyear();
    $pdf->Write(5, '民國 '.$nextyear.' 年 4 月 4 日止', '');
    $pdf->SetXY(20.0, 105.0);	
    $pdf->Cell(170, 1, '', 'T', 2, 'L', false);
    //過帳聯
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 120.0);
    $pdf->Write(5, '過', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 116.0);
    $pdf->Write(5, '過帳(   )', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(125.0, 116.0);
    $pdf->Write(5, '聯單編號：', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 125.0);
    $pdf->Write(5, '墓籍編號：' . '', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(125.0, 125.0);
    $pdf->Write(5, '墓基編號：'. '     區     號之', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 140.0);
    $pdf->Write(5, '起訖日期：', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(61.0, 139.0);
    $pdf->Write(5,  '民國 '.$year.' 年 4 月 5 日起', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(61.0, 144.0);
    $pdf->Write(5,  '民國 '.$nextyear.' 年 4 月 4 日止', '');
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 135.0);
    $pdf->Write(5, '帳', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(125.0, 140.0);
    $pdf->Write(5, '使用權人：' . '', '');
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(20.0, 150.0);
    $pdf->Write(5, '聯', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(35.0, 155.0);
    $pdf->Write(5, '面　　積：'.'', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(125.0, 155.0);
    $pdf->Write(5, '費　　用：' .'', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(160.0, 165.0);
    $pdf->Write(5, '收　費　訖　章', '');
    $pdf->SetXY(160.0, 170.0);   
    $pdf->Cell(27, 1, '', 'T', 2, 'L', false);
    //憑證
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(22.0, 180.0);
    $pdf->Write(5, '清水安樂公園化示範墓園服務處代辦各別環境美化費憑證', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(23.0, 190.0);
    $pdf->Write(5, '服務電話: (04)26200033 0903995568　郵政劃撥帳號 02485819戶名　楊得辛', '');
    $pdf->SetXY(23.0, 200.0);
    $pdf->Cell(160, 70, '', '1', 2, 'L', false);
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 202.0);
    $pdf->Write(5, '墓基編號：'. ' ', '');
    $pdf->SetXY(77.0, 202.0);
    $pdf->Write(5, '使用權人：'.' ','');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 208.0);
    $pdf->Write(5, '墓籍編號：'.' ', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(77.0, 208.0);
    $pdf->Write(5, '地址：'.' ', '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 214.0);
    $pdf->Write(5, '起訖日期：', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(46.0, 214.0);
    $pdf->Write(5, '民國 '.' '.' 年 4 月 5 日起', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
    $pdf->SetXY(90.0, 214.0);
    $pdf->Write(5,  '民國 '.' '.' 年 4 月 4 日止', '');	
    $pdf->SetXY(23.0, 220.0);	 
    $pdf->Cell(160, 1, '', 'T', 2, 'L', false);	
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(30.0, 220.0);
    $pdf->Write(5, '名　稱', '');	
    $pdf->SetXY(23.0, 228.0);	 
    $pdf->Cell(160, 1, '', 'T', 2, 'L', false);	
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(59.0, 220.0);
    $pdf->Write(5, '坪　位', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(89.0, 220.0);
    $pdf->Write(5, '金　額', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(119.0, 220.0);
    $pdf->Write(5, '備　註', '');
    $pdf->SetFont('edusongbig5', '', 13, '', true);
    $pdf->SetXY(25.0, 230.0);
    $pdf->Write(5, '環境美化費', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(63.0, 230.0);
    $pdf->Write(5, ' ', '');
    $pdf->SetXY(90.0, 230.0);
    $pdf->Write(5, ' ', '');
    $pdf->SetFont('edusongbig5', '', 8, '', true);
    $pdf->SetXY(114.0, 229.0);
    $pdf->Write(5, '資料校正，相關資料及地址若有異動或需更正者，請', '');
    $pdf->SetFont('edusongbig5', '', 8, '', true);
    $pdf->SetXY(114.0, 232.0);
    $pdf->Write(5, '至服務處填寫申請書辦理資料變更', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
	
    	$pdf->SetXY(24.0, 265.0);
    	$pdf->Write(5, '特別備註：'.' ', '');		

    $pdf->SetXY(24.0, 271.0);
    $pdf->Write(5, '(本憑單收費及塗改須另加簽章後生效)　　承　辦　人：楊　得　辛　　出　納：', '');

    $pdf->SetXY(53.0, 220.0);	 
    $pdf->Cell(1, 50, '', 'L', 2, 'T', false);	
    $pdf->SetXY(81.0, 220.0);	 
    $pdf->Cell(1, 50, '', 'L', 2, 'T', false);	
    $pdf->SetXY(112.0, 220.0);	 
    $pdf->Cell(1, 50, '', 'L', 2, 'T', false);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('BLANK.pdf', 'I');
?>