<?php
if(!empty($_POST['genre']))
{
include("../../php/connect_mssql_db.php");
 
 $genre ="'".iconv("UTF-8","windows-1251", $_POST['genre'])."'";

  $result = sqlsrv_query($conn,"exec deleteGenre $genre;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>