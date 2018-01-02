<?php
$mysql= mysql_connect("localhost", "root", "");
//new mysqli("localhost","root","","outsider");//connects to server containing the desired DB
mysql_query("SET NAMES UTF8");
mysql_select_db("outsider");
mysql_set_charset('utf8');
?>