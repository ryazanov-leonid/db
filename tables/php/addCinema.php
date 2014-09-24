<?php
if(!empty($_POST['name']) && !empty($_POST['dateRealese']) && !empty($_POST['duration']) && !empty($_POST['director']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['country']) && !empty($_POST['genres']) && !empty($_POST['actors']) && !empty($_FILES['image'])){

	$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
	$date = "'".iconv("UTF-8","windows-1251", $_POST['dateRealese'])."'";
	$duration = "'".iconv("UTF-8","windows-1251", $_POST['duration'])."'";
	$director = "'".iconv("UTF-8","windows-1251", $_POST['director'])."'";
	$description = "'".iconv("UTF-8","windows-1251", $_POST['description'])."'";
	$category = "'".iconv("UTF-8","windows-1251", $_POST['category'])."'";
	$country = "'".iconv("UTF-8","windows-1251", $_POST['country'])."'";
	$genres="'";
	$actors="'";
	for($i=0;$i<count($_POST['genres']);++$i){
		$genres.=iconv("UTF-8","windows-1251", $_POST['genres'][$i]).',';
	}
	for($i=0;$i<count($_POST['actors']);++$i){
		$actors.=iconv("UTF-8","windows-1251", $_POST['actors'][$i]).',';
	}
	$genres=substr($genres,0,strlen($genres)-1)."'";
	$actors=substr($actors,0,strlen($actors)-1)."'";
	include("../../php/connect_mssql_db.php");	
	$result = sqlsrv_query($conn,"exec addInfoAboutKino $name, $date,$duration, $director, $description, $category, $country, $genres, $actors;");
	if(!$result) {
		echo "404";
		exit();
	}
	if($row = sqlsrv_fetch_array($result)){
		if($row[0]==1000){
			echo "Error: введенная дата некорректна!<br/><a href='../cinema.php?name=".$_POST['name']."&release=".$_POST['dateRealese']."&duration=".$_POST['duration']."&director=".$_POST['director']."&description=".$_POST['description']."&category=".$_POST['category']."&country=".$_POST['country']."&genre=".$_POST['genres'][0]."&actor=".$_POST['actors'][0]."#show'>Назад</a>";
			exit();
		}else{
		  	$target_path = "../../img/";
	        $target_path = $target_path.$row[0].'.jpg'; 
	        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
	            header("Location:../cinema.php");
	        }
	        else {
	        	echo "постер не добавлен!<br/><a href='../cinema.php>Назад</a>";
	        	exit();
	        }
		}
	}
	sqlsrv_close($conn);
}
else echo "error2!<br/><a href='../cinema.php'>Назад</a>";
?>