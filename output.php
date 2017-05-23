<?php
//error_reporting(0);解決總計預設值
include("connect.php");
header("Content-type: text/html; charset=utf-8");
include_once ('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/lang/eng.php');
$datenew=$_POST['goto'];
/*$dateyy=$_POST['gotoyy'];
$datemm=$_POST['gotomm'];
$datedd=$_POST['gotodd'];
$dateoutput=$dateyy.$datemm."-".$datedd;
$dateload=$dateyy." ".$datemm." - ".$datedd;*/
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
      public function ColoredTable($header,$datenew) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.4);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 30, 45, 40, 35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
          $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        /*$fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');*/
        $fill = 0;
        $sql="SELECT l_name,l_price,l_kind,SUM(l_num) as l_num,SUM(l_total) as l_total FROM last_list where l_date LIKE '%".$datenew."%' GROUP BY l_name";
        $result=mysql_query($sql);
        while($row=mysql_fetch_array($result)){
          $l_name=$row['l_name'];
          $l_price=$row['l_price'];
          $kind=$row['l_kind'];
          $total=$row['l_total'];
          $num=$row['l_num'];
          $this->Cell($w[0], 6, $l_name, 'LR', 0, 'L', $fill);
          $this->Cell($w[1], 6, $l_price, 'LR', 0, 'R', $fill);
          $this->Cell($w[2], 6, $kind, 'LR', 0, 'R', $fill);
          $this->Cell($w[3], 6, $num, 'LR', 0, 'R', $fill);
          $this->Cell($w[4], 6, $total, 'LR', 0, 'R', $fill);
          $this->Ln();
          $fill=!$fill;
        }
        $sql="SELECT SUM(l_num) as l_num,SUM(l_total) as l_total FROM last_list where l_date LIKE '%".$datenew."%' GROUP BY l_num";
        $result=mysql_query($sql);
        $num=0;$total=0;
        while($row=mysql_fetch_array($result)){
          $num=$num+$row['l_num'];
          $total=$total+$row['l_total'];}
          $this->Cell($w[0], 6, "總計", 'LR', 0, 'L', $fill);
          $this->Cell($w[1], 6, "", 'LR', 0, 'L', $fill);
          $this->Cell($w[2], 6, "", 'LR', 0, 'R', $fill);
          $this->Cell($w[3], 6, $num, 'LRT', 0, 'R', $fill);
          $this->Cell($w[4], 6, $total, 'LRT', 0, 'R', $fill);
          $fill=!$fill;
          $this->Ln();
          $this->Cell(array_sum($w), 0, '', 'T');
        }
      }
      $pdf = new PDF_report1('P','mm','A4', true, 'UTF-8', false);

      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Nicola');
      $pdf->SetTitle('saletotal');
      $pdf->SetSubject('TCPDF Tutorial');
      $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default font subsetting mode
      $pdf->setFontSubsetting(true);
// set font 文字(繁體中文) UTF-8
      $pdf->SetFont('msungstdlight', '', 18);
// set default header data 頁首文字設定
      $pdf->SetHeaderData("", "", $datenew.'銷售統計表', "測試繁體中文頁首字串內容");
// set header and footer fonts 頁首.尾字型設定
      $pdf->setHeaderFont(Array('msungstdlight', '', 24));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
      $header = array('餐點名稱', '餐點單價','餐點種類', '數量', '小計');
// data loading 
      $data = $pdf->LoadData();
// print colored table
      $pdf->ColoredTable($header, $datenew);
      $pdf->Output('test.pdf', 'I');
      ?>