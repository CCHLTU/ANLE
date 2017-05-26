<?php
//劃撥單
error_reporting(0);//解決總計預設值
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
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
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
    $pdf->SetXY(27.0, 35.0);
    $pdf->Write(5, $address, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(162.0, 45.0);
    $pdf->Write(1, $newbase_id, '');
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $pdf->SetXY(20.0, 50.0);	
    $pdf->Cell(170, 1, '', 'T', 2, 'L', false);
	//細項說明
    $pdf->SetFont('edusongbig5', '', 14, '', true);
    $pdf->SetXY(25.0, 53.0);
    $newdate=$year.'-'.$indate;
    $pdf->Write(5, '日期：'. $newdate, '');
    $pdf->SetXY(75.0, 53.0);
    $pdf->Write(5, '墓基編號：' . $base_id, '');	
    $pdf->SetXY(135.0, 53.0);
    $pdf->Write(5, '使用權人：' . $rightuser, '');
    $pdf->SetXY(25.0, 60.0);
    $pdf->Write(5, '單據編號' . $paynumber, ''); 
    $pdf->SetXY(75.0, 60.0);
    $pdf->Write(5, '主旨：'.$titleinput, '');
    $pdf->SetXY(135.0, 60.0);
    $pdf->Write(5, '說明：'.$textinput, '');
    $pdf->SetXY(25.0, 65.0);
    $pdf->Write(5, '項目', '');
    $pdf->SetXY(45.0, 65.0);
    $pdf->Write(5, '明細', '');
    $pdf->SetXY(115.0, 65.0);
    $pdf->Write(5, '應收費用', '');
    $i=0;
    for($o=0;$o<=count($moneyall)-1;$o++){if(empty($moneyall[$o])!= true){$i++;}}
    $pdf->SetFont('edusongbig5', '', 12, '', true);
    $hi=0;
    for($o=0;$o<=$i-1;$o++){
        $pdf->SetXY(25.0, 70.0+$hi);
        $pdf->Write(5, $o+1, '');
        $pdf->SetXY(45.0, 70.0+$hi);
        $pdf->Write(5, $textall[$o], '');
        $pdf->SetXY(115.0, 70.0+$hi);
        $pdf->Write(5, $moneyall[$o], '');
        $hi=$hi+5;
    }
    $pdf->SetXY(45.0, 70.0+$hi);
    $pdf->Write(5, '合  計', '');
    $pdf->SetXY(115.0, 70.0+$hi);
    $pdf->Write(5, $allmoney, '');
/*輸入內容位置
$pdf->SetFont('edusongbig5', '', 16, '', true);
$pdf->SetXY(30.0,50.5);
$pdf->Write(5, '請持劃撥單至郵局劃撥若已現場繳費者，本單作廢', '');
$pdf->SetXY(30.0,58.5);
$pdf->Write(5, '敬請清明節前利用劃撥繳費，避免現場繳費，久候費時', '');
$pdf->SetXY(30.0, 70.0);
$pdf->multicell(180, 1, $IN, 0,'L',0);
	//$pdf->multicell(227, 1, $rollsave, 0,'L',0);
*/

//沿線撕下
$pdf->SetXY(0.0,153.5);
$pdf->Write(5, '請沿此線撕下', '');
$pdf->SetXY(0.0,157.5);
$pdf->Cell(227, 1, '', 'B', 2, 'L', false);
//匯款單圖片 21:11
$pdf->Image($file='newimg.png',0.0,165,'','','PNG');
//匯款單內容
$pdf->SetFont('edusongbig5', '', 21, '', true);
$y=strlen($allmoney);
$v=137.5;
for($c=1;$c<=$y;$c++){
	$u=substr($allmoney,$y-$c,1);
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
$pdf->SetFont('edusongbig5', '', 18, '', true);
$pdf->SetXY(6.0, 200.0);
$pdf->Write(1, $base_id, '');
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
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($year.'allocation.pdf', 'I');
?>