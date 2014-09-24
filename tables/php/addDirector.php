<?php
if(!empty($_POST['name']) && !empty($_POST['date']) && !empty($_POST['country']) && !empty($_POST['gender']))
{

$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
$date = "'".iconv("UTF-8","windows-1251", $_POST['date'])."'";
$country = "'".iconv("UTF-8","windows-1251", $_POST['country'])."'";
$gender = "'".iconv("UTF-8","windows-1251", $_POST['gender'])."'";

include("../../php/connect_mssql_db.php");

  $result = sqlsrv_query($conn,"exec addDirector $name,$date,$country,$gender;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>