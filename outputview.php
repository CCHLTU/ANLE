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
<form action=".php" method=POST>
   <table class="table table-hover">
      <tr>
         <td style=height:1%;width:5%; align='left' valign=middle>墓籍號碼</td>
         <td style=height:100%;width:9%; align='left' valign=middle>墓基號碼</td>
         <td style=height:100%;width:9%; align='left' valign=middle>面積</td>
         <td style=height:100%;width:10%; align='left' valign=middle>使用權人</td>
         <td style=height:100%;width:20%; align='left' valign=middle>使用者</td>
         <td style=height:100%;width:13.5%; align='left' valign=middle>遷出日期</td>
      </tr>
      <?php
      $sqlyear="select * from move_out";
      $resultyear=mysql_query($sqlyear);			
      while($rowyear=mysql_fetch_array($resultyear)){
        $newbaseryear=substr($rowyear['base_id'],0,3) ."區" . substr($rowyear['base_id'],4,2) ."號之". substr($rowyear['base_id'],7,2);
        echo "<tr><td style=height:1%;width:5%; align='left' valign=middle> ". $rowyear['roll_id'] ."</td>";
        echo "<td style=height:100%;width:9%; align='left' valign=middle> ". $newbaseryear ."</td>";       
        echo "<td style=height:100%;width:9%; align='left' valign=middle> ". $rowyear['area'] ."</td>";
        echo "<td style=height:100%;width:10%; align='left' valign=middle> ". $rowyear['rightuser'] ."</td>";
        echo "<td style=height:100%;width:20%; align='left' valign=middle> ". $rowyear['username'] ."</td>";
        echo "<td style=height:100%;width:13.5%; align='left' valign=middle>". $rowyear['moveday'] ."</td>";
        echo "<input type=hidden name=year value=".$relationship.">";
        echo "<input type=hidden name=base_id[] value=".$rowyear['moveday'].">";
        echo "</tr>";  
     }
     echo "</table>";
  mysql_free_result($result); //釋放記憶
  ?>
</table>