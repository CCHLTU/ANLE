<?php
include("connect.php");
/*
//因為使用EasyPHP1-8版本, 變換目錄到mysql/bin下面 
chdir("C:\Users\A-H-PC\Desktop");
echo getcwd()."<br>"; 
//開始執行mysqldump語法 
//$mysqldump_cmd="mysqldump -u root -h 127.0.0.1  test > test.sql"; 
$mysqldump_cmd="mysqldump -uroot --all-databases > tmysql.sql";
//mysqldump -u root -e -p test >C:\Users\A-H-PC\Desktop\test.sql
//mysqldump -u root -e --all-test > C:\Users\A-H-PC\Desktop\mysql.sql
$exec = exec("mysqldump -u root -p root test > C:\Users\A-H-PC\Desktop\mysql.sql" , $output, $return);
echo $exec;
echo "<br />----------------<br />";
print_r( $output );
echo "<br />----------------<br />";
print_r( $return );
*/
$MYSQL_SERVER = "localhost"; // mysql主機名稱
$MYSQL_USER = "anle"; // mysql主機帳號
$MYSQL_PASSWD = "anle123"; // mysql主機密碼
$tb_names="test";
$PATHTOMYSQLDUMP = "C:/wamp64/bin/mysql/mysql5.7.14/bin/"; // 程式mysqldump的路徑所在
$HOSTNAME="test";
$DIRNAME= "C:/"; // 要備份到那個路徑，以下都不要管！
/*
$DIRNAME.=date( "Ymd"); // add date identifier
$DIRNAME.= "/"; // add trailing slash
*/
//***************************************************************************

echo "Creating New Back Up Directory\n\n";

echo "Using Directory : $DIRNAME<br>\n";


//***************************************************************************
// The directory creation or ommission, depending if a backup was already
// completed
//***************************************************************************

if (@mkdir ($DIRNAME,0700)) {
echo "New Directory Created<br>";
} else {
echo "Directory already exists!";
}

echo "Backing Up all Databases on $HOSTNAME<br>";

//***************************************************************************
// Connect to the database server and retrieve all database names,
// store these in an array $tb_names[], for later use.
//***************************************************************************
/*
mysql_connect($MYSQL_SERVER,$MYSQL_USER,$MYSQL_PASSWD);

$result = mysql_list_dbs($x);
$i = 0;
while ($i < mysql_num_rows ($result)) {
$tb_names[$i] = mysql_tablename ($result, $i);
$i++;
}
*/
//***************************************************************************
// Loop through the table names, and do the dump.
//***************************************************************************
echo $PATHTOMYSQLDUMP. "mysqldump -h".$MYSQL_SERVER. " -u".$MYSQL_USER. " -p".$MYSQL_PASSWD. " ".$tb_names. " > ".$DIRNAME.$tb_names. ".sql";
$COMMAND_DO=$PATHTOMYSQLDUMP. "mysqldump -h".$MYSQL_SERVER. " -u".$MYSQL_USER. " -p".$MYSQL_PASSWD. " ".$tb_names. " > ".$DIRNAME.$tb_names. ".sql";
//echo $COMMAND_DO."\n"; // uncomment these lines if you want to see all
//flush(); // back-ups made on the server
exec($COMMAND_DO); // execute each backup
echo "<br>DONE!";
?>