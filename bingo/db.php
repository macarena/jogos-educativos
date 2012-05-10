<?php

$host = 'localhost';
$db = 'bingo';
$user = 'root';
$pass = 'M@c@r3n@';

$link = mysql_connect($host, $user, $pass);

if (!$link) {
    die('Não foi possível conectar: ' . mysql_error());
}

$db_selected = mysql_select_db($db, $link);
if (!$db_selected) {
    die ("Não é possível usar $db : " . mysql_error());
}

?>
