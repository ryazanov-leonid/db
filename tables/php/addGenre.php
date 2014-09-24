<?php
if(!empty($_POST['genre']))
{

$genre = "'".$_POST['genre']."'";

include("../../php/connect_mssql_db.php");
 
 $genre = iconv("UTF-8","windows-1251", $genre);

  $result = sqlsrv_query($conn,"exec addGenre $genre;");
  if (!$result){
        echo "false";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>