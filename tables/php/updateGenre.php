<?php
if(!empty($_POST['genre']) && !empty($_POST['value']))
{

$genre = "'".$_POST['genre']."'";
$value = "'".$_POST['value']."'";

include("../../php/connect_mssql_db.php");
 
 $genre = iconv("UTF-8","windows-1251", $genre);
 $value = iconv("UTF-8","windows-1251", $value);

  $result = sqlsrv_query($conn,"exec updateGenre $genre,$value;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>