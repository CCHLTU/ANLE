<?php
//收據表
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
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
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
function getmonday(){
    $today = getdate();
    date("Y/m/d H:i");  //日期格式化
    $month=$today["mon"]; //月
    $day=$today["mday"];  //日
    if(strlen($month)=='1')$month='0'.$month;
    if(strlen($day)=='1')$day='0'.$day;
    $today=$month."-".$day;
    return $today;
}
$base_idA=$_POST['base_idA'];$base_idB=$_POST['base_idB'];$base_idC=$_POST['base_idC'];
$base_id=$base_idA.'-'.$base_idB.'-'.$base_idC;
$newbase_id=$base_idA.'區'.$base_idB.'號之'.$base_idC;
$titleinput=$_POST['titleinput'];//主旨
$textinput=$_POST['textinput'];//說明
$s=0;
foreach($_POST['textall'] as $value){//
    $textall[$s]=$value;$s++;
}
$s=0;
foreach($_POST['moneyall'] as $value){//
    $moneyall[$s]=$value;$s++;
}
$allmoney=0;
for($o=0;$o<=count($moneyall)-1;$o++)
{
    $allmoney=$allmoney+$moneyall[$o];
}

$paynumber=0;
$sql="select * from roll_main where base_id='$base_id'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$roll_id=$row['roll_id'];
$address=$row['address'];
$rightuser=$row['rightuser'];

$selsql="select paynumber from servericespayindex order by paynumber";
$selresult=mysql_query($selsql);
while($selrow=mysql_fetch_array($selresult)){
    $paynumber=$selrow['paynumber'];
}
$paynumber++;
$year=getToday();
$indate=getmonday();
$insertser="insert into servericespayindex(paynumber,base_id,year,indate,titleinput,paytype,rightuser,paidmoney,yeapaid,notpaid) values($paynumber,'$base_id','$year','$indate','$titleinput','2','$rightuser',$allmoney,0,0)";
$inserresult=mysql_query($insertser)or die(mysql_error());
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
	//信封表頭 輸出時除去空墓位
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
    $pdf->SetXY(27.0, 35.0);
    $pdf->Write(5, $address, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(162.0, 45.0);
    $pdf->Write(1, $newbase_id, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(20.0, 55.0);	
    $pdf->Cell(170, 1, '', 'T', 2, 'L', false);
	//細項說明
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(25.0, 64.0);
    $newdate=$year.'-'.$indate;
    $pdf->Write(5, '日期：'. $newdate, '');
    $pdf->SetXY(75.0, 64.0);
    $pdf->Write(5, '墓基編號：' . $base_id, '');	
    $pdf->SetXY(135.0, 64.0);
    $pdf->Write(5, '使用權人：' . $rightuser, '');
    $pdf->SetXY(25.0, 72.0);
    $pdf->Write(5, '單據編號' . $paynumber, ''); 
    $pdf->SetXY(25.0, 80.0);
    $pdf->Write(5, '主旨：'.$titleinput, '');
    $pdf->SetXY(115.0, 80.0);
    $pdf->Write(5, '說明：'.$textinput, '');
    $pdf->SetXY(25.0, 90.0);
    $pdf->Write(5, '項目', '');
    $pdf->SetXY(45.0, 90.0);
    $pdf->Write(5, '明細', '');
    $pdf->SetXY(115.0, 90.0);
    $pdf->Write(5, '應收費用', '');
    $i=0;
    for($o=0;$o<=count($moneyall)-1;$o++){if(empty($moneyall[$o])!= true){$i++;}}
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $hi=0;
    for($o=0;$o<=$i-1;$o++){
        $pdf->SetXY(25.0, 95.0+$hi);
        $pdf->Write(5, $o+1, '');
        $pdf->SetXY(45.0, 95.0+$hi);
        $pdf->Write(5, $textall[$o], '');
        $pdf->SetXY(115.0, 95.0+$hi);
        $pdf->Write(5, $moneyall[$o], '');
        $hi=$hi+5;
    }
    $pdf->SetXY(45.0, 95.0+$hi);
    $pdf->Write(5, '合  計', '');
    $pdf->SetXY(115.0, 95.0+$hi);
    $pdf->Write(5, $allmoney, '');
    //憑證
    $sersql="select * from services";
    $serresult=mysql_query($sersql);
    $serrow=mysql_fetch_array($serresult);
    $pdf->SetFont('edusongbig5', '', 18, '', true);
    $pdf->SetXY(22.0, 180.0);
    $pdf->Write(5, '清水安樂公園化示範墓園服務處代辦各別環境美化費憑證', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(23.0, 190.0);
    $pdf->Write(5, '服務電話:'.$serrow['serverphone'].' '.$serrow['serverphone2'].'郵政劃撥帳號'.$serrow['servermoney'].'戶名'.$serrow['servername'], '');
    $pdf->SetXY(23.0, 200.0);
    $pdf->Cell(160, 70, '', '1', 2, 'L', false);
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 202.0);
    $pdf->Write(5, '墓基編號：'. $newbase_id, '');
    $pdf->SetXY(77.0, 202.0);
    $pdf->Write(5, '使用權人：'.$rightuser,'');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 208.0);
    $pdf->Write(5, '墓籍編號：'.$roll_id, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(77.0, 208.0);
    $pdf->Write(5, '地址：'.$address, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(24.0, 214.0);
    $pdf->Write(5, '日期：'. $newdate, '');
    $pdf->SetXY(23.0, 220.0);	 
    $pdf->Cell(160, 1, '', 'T', 2, 'L', false);	
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(30.0, 220.0);
    $pdf->Write(5, '名　稱', '');	
    $pdf->SetXY(23.0, 228.0);	 
    $pdf->Cell(160, 1, '', 'T', 2, 'L', false);	
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(59.0, 220.0);
    $pdf->Write(5, '筆　數', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(89.0, 220.0);
    $pdf->Write(5, '金　額', '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(119.0, 220.0);
    $pdf->Write(5, '備　註', '');
    $pdf->SetFont('edusongbig5', '', 13, '', true);
    $pdf->SetXY(25.0, 230.0);
    $pdf->Write(5, $titleinput, '');
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(63.0, 230.0);
    $pdf->Write(5, $i, '');
    $pdf->SetXY(90.0, 230.0);
    $pdf->Write(5, $allmoney, '');
    $pdf->SetFont('edusongbig5', '', 8, '', true);
    $pdf->SetXY(114.0, 229.0);
    $pdf->Write(5, '資料校正，相關資料及地址若有異動或需更正者，請', '');
    $pdf->SetFont('edusongbig5', '', 8, '', true);
    $pdf->SetXY(114.0, 232.0);
    $pdf->Write(5, '至服務處填寫申請書辦理資料變更', '');
    $pdf->SetFont('edusongbig5', '', 10, '', true);
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
$pdf->Output('moneyreceipt.pdf', 'I');
?>