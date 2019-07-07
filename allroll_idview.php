<?php
//墓籍編號名冊
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
    public function ColoredTable() {
        $header = array('墓籍編號', '墓基編號', '使用權人', '聯絡人二','遷出備註');
        // Colors, line width and bold font
    	$this->SetFillColor(255, 0, 0);
    	$this->SetTextColor(0);
    	$this->SetDrawColor(128, 0, 0);
    	$this->SetLineWidth(0.4);
    	$this->SetFont('', 'B');
        // Header
        $w = array(30,50,30,30,50);//表格欄數為6並設定欄位寬度
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
        	$this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 0);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(225, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $i=0;
        $fill = 0;//true為不透明 false為透明
        // Data 列出墓籍編號及相關資料
        $sql="select base_id,roll_id,rightuser,rightuser2,null as moveday from roll_main WHERE (rightuser NOT IN ('待查','空')) and (roll_id NOT IN (0)) union select base_id,roll_id,rightuser,null,moveday from move_out order by roll_id ASC";
        $result=mysql_query($sql);
        while($row=mysql_fetch_array($result)){
            $roll_id=$row['roll_id'];
            $base_id=$row['base_id'];
            $newbase=substr($base_id,0,3) ."區" . substr($base_id,4,2) ."號之". substr($base_id,7,2);//更換格式100-01-00-->100區01號之00
            $rightuser=$row['rightuser'];
            $rightuser2=$row['rightuser2'];
            $mark=$row['moveday'];
        	$this->Cell($w[0], 6, $roll_id, 'BL', 0, 'C', $fill);
        	$this->Cell($w[1], 6, $newbase, 'BL', 0, 'C', $fill);
        	$this->Cell($w[2], 6, $rightuser, 'BL', 0, 'C', $fill);
        	$this->Cell($w[3], 6, $rightuser2, 'BL', 0, 'C', $fill);
            $this->Cell($w[4], 6, $mark, 'BL', 0, 'L', $fill);
        	$this->Ln();//換行
            if(($this->getPageHeight()-$this->getY())<($this->getBreakMargin()+1)){
                $this->AddPage();
                for($i = 0; $i < $num_headers; ++$i) {
                    $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 0);
                }
            $this->Ln();
           }
        }
    }
}
$pdf = new PDF_report1('P','mm','A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola');
$pdf->SetTitle('allroll_idview');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// set font 文字(繁體中文) UTF-8
$pdf->SetFont('msungstdlight', '', 18);
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
$pdf->Output('allroll_idview.pdf', 'I');
?>