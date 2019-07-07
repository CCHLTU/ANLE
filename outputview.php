<?php
error_reporting(0);//解決roll_id初始化無值
header("Content-type: text/html; charset=utf-8");
include("connect.php");
?>
<script src="js/mainjs.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<script  src="js/bootstrap.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="http://mybidrobot.allalla.com/jquery/jquery.ui.datepicker-zh-TW.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<a href="index.html" class="btn btn-primary" role="button" ><font size="5">回前頁</font></a>
<a href="outputinster.html" class="btn btn-success" role="button" ><font size="5">新增遷出資料</font></a>
<div style="text-align:center;width:300px;;margin:0 auto;">
        <h1>遷出資料總覽</h1><br>
</div>
<a href="moveoutview.php" class="btn btn-primary" role="button" ><font size="5">列印</font></a>
   <table class="table table-hover">
      <tr>
         <td style=height:1%;width:5%; align='left' valign=middle>墓籍號碼</td>
         <td style=height:100%;width:9%; align='left' valign=middle>墓基號碼</td>
         <td style=height:100%;width:3%; align='left' valign=middle>面積</td>
         <td style=height:100%;width:7%; align='left' valign=middle>使用權人</td>
         <td style=height:100%;width:15%; align='left' valign=middle>使用者</td>
         <td style=height:100%;width:3%; align='left' valign=middle>關係</td>
         <td style=height:100%;width:5%; align='left' valign=middle>啟用日期</td>
         <td style=height:100%;width:5%; align='left' valign=middle>存放方式</td>
         <td style=height:100%;width:7%; align='left' valign=middle>電話</td>
         <td style=height:100%;width:13%; align='left' valign=middle>地址</td>
         <td style=height:100%;width:5%; align='left' valign=middle>收費標準</td>
         <td style=height:100%;width:7%; align='left' valign=middle>遷出日期</td>
         <td style=height:100%;width:10%; align='left' valign=middle>刪除資料</td>
      </tr>
      <?php
      $sqlyear="select * from move_out";
      $resultyear=mysql_query($sqlyear);			
      while($rowyear=mysql_fetch_array($resultyear)){
        $newbaseryear=substr($rowyear['base_id'],0,3) ."區" . substr($rowyear['base_id'],4,2) ."號之". substr($rowyear['base_id'],7,2);
        echo "<tr><td style=height:1%;width:5%; align='left' valign=middle> ". $rowyear['roll_id'] ."</td>";
        echo "<td style=height:100%;width:9%; align='left' valign=middle> ". $newbaseryear ."</td>";       
        echo "<td style=height:100%;width:3%; align='left' valign=middle> ". $rowyear['area'] ."</td>";
        echo "<td style=height:100%;width:7%; align='left' valign=middle> ". $rowyear['rightuser'] ."</td>";
        echo "<td style=height:100%;width:15%; align='left' valign=middle> ". $rowyear['username'] ."</td>";
        echo "<td style=height:100%;width:3%; align='left' valign=middle> ". $rowyear['relationship'] ."</td>";
        echo "<td style=height:100%;width:5%; align='left' valign=middle> ". $rowyear['startday'] ."</td>";
        echo "<td style=height:100%;width:5%; align='left' valign=middle> ". $rowyear['type'] ."</td>";
        echo "<td style=height:100%;width:7%; align='left' valign=middle> ". $rowyear['phone'] ."</td>";
        echo "<td style=height:100%;width:13%; align='left' valign=middle> ". $rowyear['address'] ."</td>";
        echo "<td style=height:100%;width:5%; align='left' valign=middle> ". $rowyear['price'] ."</td>";
        echo "<td style=height:100%;width:7%; align='left' valign=middle>". $rowyear['moveday'] ."</td>";
        echo "<td style=height:100%;width:10%; align='left' valign=middle>
        <form action='move_out_del.php' method='post'>
        <input type=hidden name=roll_id value=".$rowyear['roll_id'].">
        <input type=hidden name=base_id value=".$rowyear['base_id'].">
        <input type=hidden name=moveday value=".$rowyear['moveday'].">
        <button type='submit' class='btn btn-danger'><font size='3'>刪除遷出資料</font></button>
        </form>
        </td>";
        echo "</tr>";  
     }
     echo "</table>";
  mysql_free_result($result); //釋放記憶
  ?>
</table>