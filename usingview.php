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
        $this->SetFillColor(220,220,220);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('');
        $datetoday=getToday();
        $this->setXY(290.0,15.0);$this->Write(5, '輸出日期：'.$datetoday, '');
        $this->Ln();
        // Header
        $w = array(25,50,15,165,40,35);//表格欄數為7並設定欄位寬度315
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 4, $header[$i], 'T', 0, 'L', 0);
        }
        $this->Ln();
        $w2 = array(25,110,110,25,60);
        $header2 = array('使用權人','地址','電話','使用序號','啟用日期');
        $num_headers2 = count($header2);
        for($i = 0; $i < $num_headers2; ++$i) {
            $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        $w3 = array(25,110,110,65,20);
        $header3 = array('聯絡人二','地址','電話','摘要備註','');
        $num_headers3 = count($header3);
        for($i = 0; $i < $num_headers3; ++$i) {
            $this->Cell($w3[$i], 4, $header3[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFont('');
        $sqlzone="SELECT * FROM  roll_main ORDER BY base_id ASC";$resultzone=mysql_query($sqlzone);$rowzone=mysql_fetch_array($resultzone);
        $this->HeaderData($rowzone['zone_number']);//第一頁頁首墓基標記
        $newtag='';
        $oldtag=$rowzone['zone_number'];//第一頁頁首墓基
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
            $sqlmark="SELECT * FROM  mark_main where base_id='".$base_id."'";$resultsqlmark=mysql_query($sqlmark);
            $rowmark=mysql_fetch_array($resultsqlmark);
            $spremarks=$rowmark['spremarks'];
            //echo $roll_id;
            $ca=strlen($username);
            if($ca>90){$username=substr($username,0,90);}            
            $ca=strlen($type);
            if($ca>15){$type=substr($type,0,15);}           
            $ca=strlen($relationship);
            if($ca>15){$relationship=substr($relationship,0,15);}
            $me=0;
            $me_roll="select roll_id from roll_main where roll_id=$roll_id";
            $me_re=mysql_query($me_roll);
            while($merow=mysql_fetch_array($me_re)){
                $me++;
            }
            if($roll_id==0){$roll_id="";$me=0;}
            if($rightuser=='空'){$rightuser="";}
            //if($area==0){$area=" ";}
            //multicell
            if($oldtag != $newtag){
                $oldtag=$newtag;
                $this->endPage();
                $this->AddPage();
                $this->SetFont('msungstdlight', '', 14);
                /*
                for($i = 0; $i < $num_headers; ++$i) {
                 $this->Cell($w[$i], 4, $header[$i], 'T', 0, 'L', 0);
             }$this->Ln();
        for($i = 0; $i < $num_headers2; ++$i) {
            $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
        }
        $this->Ln();
        for($i = 0; $i < $num_headers3; ++$i) {
            $this->Cell($w3[$i], 4, $header3[$i], 'B', 0, 'L', 0);
        }
        $this->Ln();
        */
            $this->HeaderData2($base_id);
            $this->SetFont('msungstdlight', '', 14);
            $this->Cell($w[0], 10, $roll_id, 'T', 0, 'L', 0);
            $this->Cell($w[1], 10, $newbase, 'TL', 0, 'L', 0);
            $this->Cell($w[2], 10, $area, 'T', 0, 'L', 0);
            if(empty($rightuser)!=true){
                $this->Cell($w[3], 10, $username, 'T', 0, 'L', 1);
                $this->Cell($w[4], 10, $relationship, 'T', 0, 'L', 1);
                $this->Cell($w[5], 10, $type, 'T', 0, 'L', 1);
            }else{
                $this->Cell($w[3], 10, $username, 'T', 0, 'L', 0);
                $this->Cell($w[4], 10, $relationship, 'T', 0, 'L', 0);
                $this->Cell($w[5], 10, $type, 'T', 0, 'L', 0);
            }
            $this->Ln();
            $this->Cell($w2[0], 4, $rightuser, 0, 0, 'L', $fill);
            $this->Cell($w2[1], 4, $address, 'L', 0, 'L', $fill);
            $this->Cell($w2[2] ,4, $phone, 0, 0, 'L', $fill);
            $this->cell($w2[3] ,4, $useingnumber, 0, 0, 'L', $fill);
            $this->Cell($w2[4], 4, $startday, 0, 0, 'L', $fill);
            $this->Ln();//換行
            $this->Cell($w3[0], 4, $rightuser2, 'B', 0, 'L', $fill);
            $this->Cell($w3[1], 4, $address2, 'BL', 0, 'L', $fill);
            $this->Cell($w3[2], 4, $phone2, 'B', 0, 'L', $fill);
            $this->cell($w3[3] ,4, '備註：'.$spremarks, 'B', 0, 'L', $fill);
            if($me>1){
                $this->cell($w3[4] ,4, $me.'筆', 'B', 0, 'L', $fill);
            }else{
                $this->cell($w3[4] ,4, '', 'B', 0, 'L', $fill);
            }
            $this->Ln();//換行            
            }else{
                $this->SetFont('msungstdlight', '', 14);
                $this->Cell($w[0], 10, $roll_id, 'T', 0, 'L', 0);
                $this->Cell($w[1], 10, $newbase, 'TL', 0, 'L', 0);
                $this->Cell($w[2], 10, $area, 'T', 0, 'L', 0);
                if(empty($rightuser)!=true){
                    $this->Cell($w[3], 10, $username, 'T', 0, 'L', 1);
                    $this->Cell($w[4], 10, $relationship, 'T', 0, 'L', 1);
                    $this->Cell($w[5], 10, $type, 'T', 0, 'L', 1);
                }else{
                    $this->Cell($w[3], 10, $username, 'T', 0, 'L', 0);
                    $this->Cell($w[4], 10, $relationship, 'T', 0, 'L', 0);
                    $this->Cell($w[5], 10, $type, 'T', 0, 'L', 0);
                }
                $this->Ln();
                $this->Cell($w2[0], 4, $rightuser, 0, 0, 'L', $fill);
                $this->Cell($w2[1], 4, $address, 'L', 0, 'L', $fill);
                $this->Cell($w2[2] ,4, $phone, 0, 0, 'L', $fill);
                $this->cell($w2[3] ,4, $useingnumber, 0, 0, 'L', $fill);
                $this->Cell($w2[4], 4, $startday, 0, 0, 'L', $fill);
                $this->Ln();//換行
                $this->Cell($w3[0], 4, $rightuser2, 'B', 0, 'L', $fill);
                $this->Cell($w3[1], 4, $address2, 'BL', 0, 'L', $fill);
                $this->Cell($w3[2], 4, $phone2, 'B', 0, 'L', $fill);
                $this->cell($w3[3] ,4, '備註：'.$spremarks, 'B', 0, 'L', $fill);
                if($me>1){
                    $this->cell($w3[4] ,4, $me.'筆', 'B', 0, 'L', $fill);
                }else{
                    $this->cell($w3[4] ,4, '', 'B', 0, 'L', $fill);
                }
                $this->Ln();//換行 
                if(($this->getPageHeight()-$this->getY())<($this->getBreakMargin()+20)){
                    $this->AddPage();
                    $this->SetFont('msungstdlight', '', 14);
                    /*
                    for($i = 0; $i < $num_headers; ++$i) {
                       $this->Cell($w[$i], 4, $header[$i], 'T', 0, 'L', 0);
                   }$this->Ln();
                   for($i = 0; $i < $num_headers2; ++$i) {
                    $this->Cell($w2[$i], 4, $header2[$i], 0, 0, 'L', 0);
                }
                $this->Ln();
                for($i = 0; $i < $num_headers3; ++$i) {
                    $this->Cell($w3[$i], 4, $header3[$i], 'B', 0, 'L', 0);
                }
                $this->Ln();
                */
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
    $rowzone=mysql_fetch_array($resultzone);
    $this->setXY(310.0,4.0);$this->Write(5, $rowzone['zone_chinese']." ".$newtag."區", '');
    $this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();//$this->Ln();
}
public function HeaderData2($newtag)
{
    $newtag=substr($newtag,0,3);
    $sqlzone="SELECT * FROM  zone_name where zone_number='".substr($newtag,0,1)."'";
    $resultzone=mysql_query($sqlzone);
    $rowzone=mysql_fetch_array($resultzone);
    $this->setXY(310.0,4.0);$this->Write(5, $rowzone['zone_chinese']." ".$newtag."區", '');
    $this->Ln();//$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();
}
}

$pdf = new PDF_report1('L','mm','B4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola');
$pdf->SetTitle('usingview');
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
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setFooterMargin($fm=5);$pdf->SetAutoPageBreak(TRUE,0);
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
$header = array('墓籍編號', '墓基編號','面積', '使用者姓名', '關係','使用種類');
// data loading 
$data = $pdf->LoadData();
// print colored table
$pdf->ColoredTable($header);
$pdf->Output('usingview.pdf', 'I');
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