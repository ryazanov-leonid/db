<?php
if(!empty($_POST['name']) && !empty($_POST['dateRealese']) && !empty($_POST['duration']) && !empty($_POST['director']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['country']) && $_POST["id"]){
	$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
	$date = "'".iconv("UTF-8","windows-1251", $_POST['dateRealese'])."'";
	$dateAdded = "'".iconv("UTF-8","windows-1251", $_POST['dateAdded'])."'";
	$duration = "'".$_POST['duration']."'";
	$director = "'".iconv("UTF-8","windows-1251", $_POST['director'])."'";
	$description = "'".iconv("UTF-8","windows-1251", $_POST['description'])."'";
	$category = "'".iconv("UTF-8","windows-1251", $_POST['category'])."'";
	$country = "'".iconv("UTF-8","windows-1251", $_POST['country'])."'";

	include("../../php/connect_mssql_db.php");

	 $result = sqlsrv_query($conn,"exec updateKino {$_POST["id"]}, $name, $date, $duration, $director, $description, $category, $country;");
	  if (!$result)echo "404";
	  else header("location:../cinema.php");
	}
	else echo "error";
?>