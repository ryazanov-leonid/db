<?php
if(!empty($_POST['id']) && !empty($_POST["name"])){
include("../../php/connect_mssql_db.php");
  $name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
 $result = sqlsrv_query($conn,"exec delGenreFromKino {$_POST["id"]}, $name;");
 if ($result){
  	  $result = sqlsrv_query($conn,"exec getGenreForKinoById {$_POST["id"]};");
	  if (!$result){
	        echo "ошибка получения доступных жанров для фильма";
	        exit();
	      }

	  $genres="<tr><td> <strong>Удалить </strong></td><td><strong> Название </strong></td></tr>";
	  while($row = sqlsrv_fetch_array($result)){
	  	$item = iconv("windows-1251","UTF-8",$row[0]);
	    $genres.='<tr><td style="width:50px"><button onclick="deleteGenre(\''.$item.'\','.$_POST["id"].')" ><i class="icon-remove"></button></td><td>'.$item.'</td></tr>';
	  }
	  $genres.=" <tr>
	                            <td><button onclick='addGenre({$_POST["id"]})' class='btn btn-success' > <span>Добавить</span> </button></td>
	                            <td><select id='addGenre'>";
	  $result = sqlsrv_query($conn,"exec getGenres;");
	  if (!$result){
	        echo "ошибка получения всех жанров";
	        exit();
	      }
	      $i=0; 
	  while($row = sqlsrv_fetch_array($result)){
	    $genres.="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
	  }
	  $genres.="</select></td></tr>";
	  echo $genres;
	}

  sqlsrv_close($conn);
}
else echo "error";
?>