<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_CALDAS = "localhost";
$database_CALDAS = "bdformulario";
$username_CALDAS = "root";
$password_CALDAS = "";
$CALDAS = mysql_pconnect($hostname_CALDAS, $username_CALDAS, $password_CALDAS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>