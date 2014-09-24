<?php
if(!empty($_POST['name']))
{
include("../../php/connect_mssql_db.php");
 
 $name ="'".iconv("UTF-8","windows-1251", $_POST['name'])."'";

  $result = sqlsrv_query($conn,"exec deleteActor $name;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>