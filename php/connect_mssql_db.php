<?php
//phpinfo();
$serverName = "USER-PC\SQLEXPRESS"; //если instance и port стандартные, то можно не указывать
$connectionInfo = array("UID" => "user", "PWD" => "admin", "Database"=>"kinocatalog");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if(!$conn)
{
die( print_r( sqlsrv_errors(), true));
}
?>