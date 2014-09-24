<?php
if(!empty($_POST['id'])){
include("../../php/connect_mssql_db.php");
  $result = sqlsrv_query($conn,"exec deleteKino {$_POST["id"]};");
  if (!$result)echo "error";
  else echo "true";
  sqlsrv_close($conn);
}
else echo "error";
?>