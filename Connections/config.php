<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_currency = "localhost";
$database_currency = "your data base name";
$username_currency = "your database username";
$password_currency = "your database password";
$currency = mysql_pconnect($hostname_currency, $username_currency, $password_currency) or trigger_error(mysql_error(),E_USER_ERROR); 
?>