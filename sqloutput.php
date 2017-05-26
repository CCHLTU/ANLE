<?php
include("connect.php");
//因為使用EasyPHP1-8版本, 變換目錄到mysql/bin下面 
chdir("C:\Users\A-H-PC\Desktop");
echo getcwd()."<br>"; 
//開始執行mysqldump語法 
//$mysqldump_cmd="mysqldump -u root -h 127.0.0.1  test > test.sql"; 
$mysqldump_cmd="mysqldump -uroot --all-databases > tmysql.sql";

$exec = exec("mysqldump -uroot --all-test > C:\Users\A-H-PC\Desktop\mysql.sql" , $output, $return);
echo $exec;
echo "<br />----------------<br />";
print_r( $output );
echo "<br />----------------<br />";
print_r( $return );
?>