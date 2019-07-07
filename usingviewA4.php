<?php
//使用名冊
//error_reporting(0);解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
include_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
class PDF_report1 extends TCPDF
{
    // Load table data from file
    public function LoadData() {
        // Read file lines
      //  $lines = file($file);
   /*     foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;*/
    }
    // Colored table
    public function ColoredTable($header) {
        // Colors, line width and bold font
        // Color and font restoration
        $this->SetFillColor(220,220,220);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('');
        // Header
        $w1 = array(25,50,30,50,35);//表格欄數為5並設定欄位寬度 第一排
        $num_headers1 = count($header);
        $w2 = array(25,120,35);//表格欄數為5並設定欄位寬度 第一排
        $header2 = array('','使用者姓名','關係');
        $num_headers2 = count($header2);
        $w3 = array(25,100,55);//表格欄數為5並設定欄位寬度 第2排
        $header3 = array('使用權人','地址','電話');
        $num_headers3 = count($header3);
        $w4 = array(25,100,55);//表格欄數為5並設定欄位寬度 第3排
        $header4 = array('聯絡人二','地址','電話');
        $num_headers4 = count($header4);
        $w5 = array(25,145,5);//表格欄數為5並設定欄位寬度 第3排
        $header5 = array('使用序號','摘要備註','');
        $num_headers5 = count($header5);
        for($i = 0; $i < $num_headers1; ++$i) {
            $this->Cell($w1[$i], 4, $header[$i], 'T', 0, 'L', 0);
        }
        $this->Ln();
        for($i = 0; $i < $num_headers2; ++$i) {
            $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        for($i = 0; $i < $num_headers3; ++$i) {
            $this->Cell($w3[$i], 4, $header3[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        for($i = 0; $i < $num_headers4; ++$i) {
            $this->Cell($w4[$i], 4, $header4[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        for($i = 0; $i < $num_headers5; ++$i) {
            $this->Cell($w5[$i], 4, $header5[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        $sqlzone="SELECT * FROM  roll_main ORDER BY base_id ASC";$resultzone=mysql_query($sqlzone);$rowzone=mysql_fetch_array($resultzone);
        $this->HeaderData($rowzone['zone_number']);//第一頁頁首墓基標記
        $newtag='';
        $oldtag=$rowzone['zone_number'];//第一頁墓基區碼為101
        // Data 列出墓籍編號及相關資料
        $fill = 0;//true為不透明 false為透明
        $sql="SELECT * FROM  roll_main ORDER BY base_id ASC";
        $result=mysql_query($sql);
        while($row=mysql_fetch_array($result)){
            $useingnumber=$row['useingnumber'];
            if($useingnumber == 0){$useingnumber=' ';}
            $roll_id=$row['roll_id'];
            $base_id=$row['base_id'];
            $sqlzone="SELECT * FROM  zone_name where zone_number='".substr($base_id,0,1)."'";
            $resultzone=mysql_query($sqlzone);
            $rowzone=mysql_fetch_array($resultzone);
            $newbase=$rowzone['zone_chinese'].substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);//更換格式100-01-00-->100區01號之00
            $area=$row['area'];
            $rightuser=$row['rightuser'];
            $username=$row['username'];
            $relationship=$row['relationship'];
            $startday=$row['startday'];
            $type=$row['type'];
            $phone=$row['phone'];
            $address=$row['address'];
            $newtag=$row['zone_number'];
            $rightuser2=$row['rightuser2'];
            $phone2=$row['phone2'];
            $address2=$row['address2'];
            $ca=strlen($type);
            if($ca>15){$type=substr($type,0,15);}           
            $ca=strlen($relationship);
            if($ca>15){$relationship=substr($relationship,0,15);}
            if($area==0){$area="";}
            $me=0;
            $me_roll="select roll_id from roll_main where roll_id=$roll_id";
            $me_re=mysql_query($me_roll);
            while($merow=mysql_fetch_array($me_re)){
                $me++;
            }
            if($roll_id==0){$roll_id="";$me=0;}
            if($rightuser=='空'){$rightuser="";}
            if($oldtag != $newtag){
                $oldtag=$newtag;
                $this->endPage();
                $this->AddPage();
                /*
                for($i = 0; $i < $num_headers1; ++$i) {
                    $this->Cell($w1[$i], 4, $header[$i], 'T', 0, 'L', 0);
                }$this->Ln();
                for($i = 0; $i < $num_headers2; ++$i) {
                    $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
                }$this->Ln();
                for($i = 0; $i < $num_headers3; ++$i) {
                    $this->Cell($w3[$i], 4, $header3[$i], 0, 0, 'L', 0);
                }$this->Ln();
                for($i = 0; $i < $num_headers4; ++$i) {
                    $this->Cell($w4[$i], 4, $header4[$i], 0, 0, 'L', 0);
                }$this->Ln();
                for($i = 0; $i < $num_headers5; ++$i) {
                    $this->Cell($w5[$i], 4, $header5[$i], 'B', 0, 'L', 0);
                }$this->Ln();
                */
                
                $this->HeaderData2($base_id);
                $this->Cell($w1[0], 4, $roll_id, 'T', 0, 'L', $fill);
                $this->Cell($w1[1], 4, $newbase, 'LT', 0, 'L', $fill);
                $this->Cell($w1[2], 4, $area, 'T', 0, 'L', $fill);
                $this->Cell($w1[3], 4, $startday, 'T', 0, 'L', $fill);
                $this->Cell($w1[4], 4, $type, 'T', 0, 'L', $fill);
                $this->Ln();
                $this->Cell($w2[0], 12, '', 'R', 0, 'L', $fill);
                if(empty($rightuser)!=true){
                    $this->MultiCell($w2[1], 12, $username, 'L', 'L', 1, 0, '', '', 0, 0, 0, 0, 0, 'T');
                    //$this->multiCell($w2[0], 10, $username, 0, 0, 'L', $fill);
                    //$this->Cell($w2[2], 12, $relationship, 0, 0, 'L', $fill);
                    $this->MultiCell($w2[2], 12, $relationship, 0, 'L', 1, 0, '', '', 0, 0, 0, 0, 0, 'T');                   
                }else{
                    $this->MultiCell($w2[1], 12, $username, 'L', 'L', 0, 0, '', '', 0, 0, 0, 0, 0, 'T');
                    $this->MultiCell($w2[2], 12, $relationship, 0, 'L', 0, 0, '', '', 0, 0, 0, 0, 0, 'T');  
                }
                $this->Ln();
                $this->Cell($w3[0], 4, $rightuser, 0, 0, 'L', $fill);
                $this->Cell($w3[1], 4, $address, 'L', 0, 'L', $fill);
                $this->cell($w3[2] ,4, $phone, 0, 0, 'L', $fill);
                $this->Ln();
                $this->cell($w4[0] ,4, $rightuser2, 0, 0, 'L', $fill);
                $this->Cell($w4[1], 4, $address2, 'L', 0, 'L', $fill);
                $this->Cell($w4[2], 4, $phone2, 0, 0, 'L', $fill);
                $this->Ln();//換行
                $this->Cell($w5[0], 4, $useingnumber, 'B', 0, 'L', $fill);
                $this->cell($w5[1] ,4, '備註：', 'BL', 0, 'L', $fill);
                if($me>1){
                    $this->cell($w5[2] ,4, $me.'筆', 'B', 0, 'L', $fill);
                }else{
                    $this->cell($w5[2] ,4, '', 'B', 0, 'L', $fill);
                }
                $this->Ln();//換行
            }else{
                $this->Cell($w1[0], 4, $roll_id, 'T', 0, 'L', $fill);
                $this->Cell($w1[1], 4, $newbase, 'LT', 0, 'L', $fill);
                $this->Cell($w1[2], 4, $area, 'T', 0, 'L', $fill);
                $this->Cell($w1[3], 4, $startday, 'T', 0, 'L', $fill);
                $this->Cell($w1[4], 4, $type, 'T', 0, 'L', $fill);
                $this->Ln();
                $this->Cell($w2[0], 12, '', 'R', 0, 'L', $fill);
                if(empty($rightuser)!=true){
                    $this->MultiCell($w2[1], 12, $username, 'L', 'L', 1, 0, '', '', 0, 0, 0, 0, 0, 'T');
                    //$this->multiCell($w2[0], 10, $username, 0, 0, 'L', $fill);
                    //$this->Cell($w2[2], 12, $relationship, 0, 0, 'L', $fill);
                    $this->MultiCell($w2[2], 12, $relationship, 0, 'L', 1, 0, '', '', 0, 0, 0, 0, 0, 'T');                   
                }else{
                    $this->MultiCell($w2[1], 12, $username, 'L', 'L', 0, 0, '', '', 0, 0, 0, 0, 0, 'T');
                    $this->MultiCell($w2[2], 12, $relationship, 0, 'L', 0, 0, '', '', 0, 0, 0, 0, 0, 'T');  
                }
                $this->Ln();
                $this->Cell($w3[0], 4, $rightuser, 0, 0, 'L', $fill);
                $this->Cell($w3[1], 4, $address, 'L', 0, 'L', $fill);
                $this->cell($w3[2] ,4, $phone, 0, 0, 'L', $fill);
                $this->Ln();
                $this->cell($w4[0] ,4, $rightuser2, 0, 0, 'L', $fill);
                $this->Cell($w4[1], 4, $address2, 'L', 0, 'L', $fill);
                $this->Cell($w4[2], 4, $phone2, 0, 0, 'L', $fill);
                $this->Ln();//換行
                $this->Cell($w5[0], 4, $useingnumber, 'B', 0, 'L', $fill);
                $this->cell($w5[1] ,4, '備註：', 'BL', 0, 'L', $fill);
                if($me>1){
                    $this->cell($w5[2] ,4, $me.'筆', 'B', 0, 'L', $fill);
                }else{
                    $this->cell($w5[2] ,4, '', 'B', 0, 'L', $fill);
                }
                $this->Ln();//換行
            if(($this->getPageHeight()-$this->getY())<($this->getBreakMargin()+30)){
                $this->AddPage();/*
                for($i = 0; $i < $num_headers1; ++$i) {
                    $this->Cell($w1[$i], 4, $header[$i], 'T', 0, 'L', 0);
                }
                $this->Ln();
                for($i = 0; $i < $num_headers2; ++$i) {
                    $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
                }
                $this->Ln();
                for($i = 0; $i < $num_headers3; ++$i) {
                    $this->Cell($w3[$i], 4, $header3[$i], 0, 0, 'L', 0);
                }
                $this->Ln();
                for($i = 0; $i < $num_headers4; ++$i) {
                    $this->Cell($w4[$i], 4, $header4[$i], 0, 0, 'L', 0);
                }                
                $this->Ln();
                for($i = 0; $i < $num_headers5; ++$i) {
                    $this->Cell($w5[$i], 4, $header5[$i], 'B', 0, 'L', 0);
                }
                $this->Ln();*/
                $this->HeaderData2($base_id);
            }//判斷表頭凍結
        }//迴圈結尾
    }
}

public function HeaderData($newtag)
{
    $newtag=substr($newtag,0,3);
    $sqlzone="SELECT * FROM  zone_name where zone_number='".substr($newtag,0,1)."'";
    $resultzone=mysql_query($sqlzone);
    $rowzone=mysql_fetch_array($resultzone);$datetoday=getToday();
    $this->setXY(175.0,4.0);//$this->Write(5, $rowzone['zone_chinese']." ".$newtag."區", '');
    $this->Cell(15, 5, $rowzone['zone_chinese']." ".$newtag."區", 0, 0, 'L', 1);
    $this->setXY(145.0,21.0);$this->Write(5, '輸出日期：'.$datetoday, '');
    $this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();//$this->Ln();$this->Ln();$this->Ln();
}
public function HeaderData2($newtag)
{
    $newtag=substr($newtag,0,3);
    $sqlzone="SELECT * FROM  zone_name where zone_number='".substr($newtag,0,1)."'";
    $resultzone=mysql_query($sqlzone);
    $rowzone=mysql_fetch_array($resultzone);
    $this->setXY(175.0,4.0);//$this->Write(5, $rowzone['zone_chinese']." ".$newtag."區", '');
    $this->Cell(15, 5, $rowzone['zone_chinese']." ".$newtag."區", 0, 0, 'L', 1);
    $this->Ln();//$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();
}
}

$pdf = new PDF_report1('P','mm','A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola');
$pdf->SetTitle('usingviewA4');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// set font 文字(繁體中文) UTF-8
$pdf->SetFont('msungstdlight', '', 14);
// set default header data 頁首文字設定
//$pdf->setPrintHeader(false);
// set header and footer fonts 頁首.尾字型設定
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// add a page
$pdf->AddPage();
// column titles
$header = array('墓籍編號', '墓基編號','面積','啟用日期', '種類');
// data loading 
$data = $pdf->LoadData();
// print colored table
$pdf->ColoredTable($header);
$pdf->Output('usingviewA4.pdf', 'I');

function getToday(){
    $today = getdate();
    date("Y/m/d H:i");  //日期格式化
    $year=$today["year"]; //年 
    $month=$today["mon"]; //月
    $day=$today["mday"];  //日
    $year=$year-1911;
    if(strlen($month)=='1')$month='0'.$month;
    if(strlen($day)=='1')$day='0'.$day;
    $today=$year."-".$month."-".$day;
    return $today;
}
?>