<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_lab = "localhost";
$database_lab = "p_labmedis";
$username_lab = "root";
$password_lab = "";
$lab = mysql_connect($hostname_lab, $username_lab, $password_lab) or trigger_error(mysql_error(),E_USER_ERROR); 
?>