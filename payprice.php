<?php
//年度收費清冊
//error_reporting(0);解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
include_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
function getToday(){
    $today = getdate();
    date("Y/m/d H:i");  //日期格式化
    $year=$today["year"]; //年 
    $month=$today["mon"]; //月
    $day=$today["mday"];  //日
    $year=$year-1911;
    $today=$year;
    //echo "今天日期 : ".$today;
    return $today;
}
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
    public function ColoredTable() {
        $header = array('墓基編號', '使用權人','面積', '費用', '收費日期','收費1','收費2','特殊備註');
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.4);
        $this->SetFont('');
        // Header
        $w = array(30,40,5,20,24,23,23,20);//表格欄數為8並設定欄位寬度
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
        	$this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 0);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(225, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->HeaderData(101);//第一頁頁首墓籍標記
        $newtag='';
        $oldtag='101';//第一頁區碼為101
        // Data 列出墓籍編號及相關資料
        $fill = 0;//true為不透明 false為透明
        $sql="SELECT roll_main.*,price_index.price FROM  roll_main,price_index where roll_main.base_id=price_index.base_id";
        $result=mysql_query($sql);
        while($row=mysql_fetch_array($result)){
            $newtag=$row['zone_number'];
            $base_id=$row['base_id'];
        	$newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);//更換格式100-01-00-->100區01號之00
        	$area=$row['area'];
        	$rightuser=$row['rightuser'];
            $price=$row['price'];
            $this->SetFont('msungstdlight', '', 13);
            if($oldtag != $newtag){
                $oldtag=$newtag;
                $this->endPage();
                $this->AddPage();
                for($i = 0; $i < $num_headers; ++$i) {
                   $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 0);
               }$this->Ln();
               $this->HeaderData($base_id);
               if($rightuser=='空' or $rightuser ==''){$rightuser='';$area='';$price='';}
               $this->Cell($w[0], 8, $newbase, 'B', 0, 'C', $fill);
               $this->Cell($w[1], 8, $rightuser, 'B', 0, 'C', $fill);
               if($area==0.1){
                $this->Cell($w[2], 8, '公寓', 'B', 0, 'C', $fill);
            }else{
                $this->Cell($w[2], 8, $area, 'B', 0, 'C', $fill);                
            }
            $this->Cell($w[3], 8, $price, 'B', 0, 'C', $fill);
            $this->Cell($w[4], 8, '', 'BL', 0, 'L', $fill);
            $this->Cell($w[5], 8, '', 'BL', 0, 'R', $fill);
            $this->Cell($w[6], 8, '', 'BL', 0, 'L', $fill);
            $this->Cell($w[7], 8, '', 'BL', 0, 'R', $fill);
            $this->Ln();//換行
        }else{
            if($rightuser=='空' or $rightuser ==''){$rightuser='';$area='';$price='';}
            $this->Cell($w[0], 8, $newbase, 'B', 0, 'C', $fill);
            $this->Cell($w[1], 8, $rightuser, 'B', 0, 'C', $fill);
            if($area==0.1){
                $this->Cell($w[2], 8, '公寓', 'B', 0, 'C', $fill);
            }else{
                $this->Cell($w[2], 8, $area, 'B', 0, 'C', $fill);                
            }
            $this->Cell($w[3], 8, $price, 'B', 0, 'C', $fill);
            $this->Cell($w[4], 8, '', 'BL', 0, 'L', $fill);
            $this->Cell($w[5], 8, '', 'BL', 0, 'R', $fill);
            $this->Cell($w[6], 8, '', 'BL', 0, 'L', $fill);
            $this->Cell($w[7], 8, '', 'BL', 0, 'R', $fill);
            $this->Ln();//換行
            if(($this->getPageHeight()-$this->getY())<($this->getBreakMargin()+6)){
                $this->AddPage();
                $this->SetFont('msungstdlight', '', 13);
                for($i = 0; $i < $num_headers; ++$i) {
                    $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 0);
                }
                $this->Ln();
                $this->HeaderData($base_id);
            }                
        }
    }
}
public function HeaderData($newtag)
{
    $newtag=substr($newtag,0,3);
    $sqlzone="SELECT * FROM  zone_name where zone_number='".substr($newtag,0,1)."'";
    $resultzone=mysql_query($sqlzone);
    $rowzone=mysql_fetch_array($resultzone);
    $this->setXY(170.0,0.5);$this->Write(5, $rowzone['zone_chinese']." ".$newtag."區", '');
    $this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();$this->Ln();
}
}
$pdf = new PDF_report1('P','mm','A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola');
$pdf->SetTitle('payprice');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// set font 文字(繁體中文) UTF-8
$pdf->SetFont('msungstdlight', '', 13);
// set default header data 頁首文字設定
$pdf->setPrintHeader(false);
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

// data loading 
$data = $pdf->LoadData();
// print colored table
$pdf->ColoredTable();
$toyear=getToday();
$pdf->Output($toyear.'payprice.pdf', 'I');
?>