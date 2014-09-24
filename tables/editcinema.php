<?php
session_start();
if(!$_SESSION["login"]) header("Location:../login.php");
include("../php/connect_mssql_db.php");
if(empty($_GET["item"])){
  header("location:cinema.php");
}
  $result = sqlsrv_query($conn,"exec getKinoById {$_GET["item"]};");
  if (!$result){
        header("location:../404.html");
        exit();
      } 
  $undef=0;     
  while($row = sqlsrv_fetch_array($result)){
    $id = $row[0];
    $name = iconv("windows-1251","UTF-8",$row[1]);
    $date = $row[2]->format('Y-m-d');
    $dateAdded = $row[3]->format('Y-m-d');
    $duration = $row[4]->format('H:i:s');
    $director = iconv("windows-1251","UTF-8",$row[5]);
    $description = iconv("windows-1251","UTF-8",$row[6]);
    $category = iconv("windows-1251","UTF-8",$row[7]);
    $country = iconv("windows-1251","UTF-8",$row[8]);
    $undef=1;
  }
  if($undef==0){
    echo "Нет такого фильма!!!";
    exit();
  }

  //////////////////////////////////////////////////////////////////////////////////////////////
  $result = sqlsrv_query($conn,"exec getGenreForKinoById {$_GET["item"]};");
  if (!$result){
        header("location:../404.html");
        exit();
      }

  $genres="<tr><td> <strong>Удалить </strong></td><td><strong> Название </strong></td></tr>";
  while($row = sqlsrv_fetch_array($result)){
    $genres.='<tr><td style="width:50px"><button onclick="deleteGenre(\''.iconv("windows-1251","UTF-8",$row[0]).'\','.$id.')" ><i class="icon-remove"></button></td><td>'.iconv("windows-1251","UTF-8",$row[0]).'</td></tr>';
  }
  $genres.=" <tr>
                            <td><button onclick='addGenre($id)' class='btn btn-success' > <span>Добавить</span> </button></td>
                            <td><select id='addGenre'/>";
  $result = sqlsrv_query($conn,"exec getGenres;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $allGenres="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $genres.="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
  }
  $genres.="</select></td></tr>";

  //////////////////////////////////////////////////////////////////////////////////////////////

  $result = sqlsrv_query($conn,"exec getActorForKinoById {$_GET["item"]};");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $actors="<tr>
                            <td> <strong>Удалить </strong></td>
                            <td><strong> Название </strong></td>
                          </tr>";

  while($row = sqlsrv_fetch_array($result)){
        $actors.='<tr><td style="width:50px"><button onclick="deleteActor(\''.iconv("windows-1251","UTF-8",$row[0]).'\','.$id.')"><i class="icon-remove"></button></td>
           <td>'.iconv("windows-1251","UTF-8",$row[0]).'</td></tr>';
  }
  $actors.="<tr>
                            <td><button class='btn btn-success' onclick='addActor($id)' <span>Добавить</span> </button></td>
                            <td><select id='addActor'>";
  $result = sqlsrv_query($conn,"exec getActors;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $allActors="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $actors.="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
  }
  $actors.="</select></td></tr>";                          

  //////////////////////////////////////////////////////////////////////////////////////////////
  $result = sqlsrv_query($conn,"exec getDirectors;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $directors="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $dir = iconv("windows-1251","UTF-8",$row[0]);
    if($director != $dir){
        $directors[$i]="<option>$dir</option>";
        ++$i;
    }
  }                
sqlsrv_close($conn);
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Кинокаталог - Таблица "Кино"</title>
    <script src="../js/jquery-1.10.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/style2.css" rel="stylesheet" media="screen">
    <link type="image/x-icon" rel="shortcut icon" href="../img/favicon.ico">
    <script src="../js/myJS.js"></script>
    <script type="text/javascript">
    function isEmpty(a){
       if (a !== "" && a !== "0" && a !== 0 && a !== null && a !== false && a !== "undefined") return false;
      return true
    }
    function goToPage(){
      var a=$("#inputIcon").val();
      if (!isEmpty(a)) document.location.href="../result.php?name="+a;
    }
    function delItem(item){
      $(item).remove();
    }
    function deleteGenre(name,id){
          $.post('php/deleteGenreFromKino.php', {"name": name,"id": id}, function(data) {
            $("#editGenre").empty();
            $("#editGenre").append(data);
          });
        }
    function addGenre(id){
      var genre = $("#addGenre").val();
      $.post('php/addGenreForKino.php', {"name":genre, "id":id}, function(data) {
        $("#editGenre").empty();
        $("#editGenre").append(data);
      });
    }
    function deleteActor(name,id){
      $.post('php/deleteActorFromKino.php',{ "name": name, "id": id}, function(data) {
        $("#editActor").empty();
        $("#editActor").append(data);
      });
    }
    function addActor(id){
      var actor = $("#addActor").val();
      $.post('php/addActorForKino.php', {"name":actor, "id":id}, function(data) {
        $("#editActor").empty();
        $("#editActor").append(data);
      });
    }
    </script>
  </head>
  <body>
    <div class="container header_container" >
      <div style="margin:10px 15px;" >
        <div><img class="header_img" title="Железный человек 3" src="../img/1.jpg"></div>
        <div><img class="header_img" title="Побег из Шоушенка" src="../img/2.jpg"></div>
        <div><img class="header_img" title="Зеленая миля" src="../img/3.jpg"></div>
        <div><img class="header_img" title="1+1" src="../img/4.jpg"></div>
        <div><img class="header_img" title="Начало" src="../img/5.jpg"></div>
        <div><img class="header_img" title="Иван Васильевич меняет профессию " src="../img/6.jpg"></div>
        <div><img class="header_img" title="Крестный отец" src="../img/7.jpg"></div>
        <div><img class="header_img" title="Легенда №17 " src="../img/8.jpg"></div>
        <div><img class="header_img" title="Властелин колец: Возвращение Короля" src="../img/9.jpg"></div>
        <div><img class="header_img" title="Игра престолов " src="../img/11.jpg"></div>
      </div>
    </div>
    <div class="container" style="width:940px;">
      <div class="navbar navbar-inverse">
        <div class="navbar-inner">
          <ul class="nav">
            <li><a href="../index.php"><i class="icon-home icon-white"> </i> Главная</a></li>
            <li><a href="../films.php">Фильмы</a></li>
            <li><a href="../serials.php">Сериалы</a></li>
            <li><a class="active" href="cinema.php">Таблицы</a></li>
            <li  style="margin-left: 280px;"> <label style="margin-bottom: 0px; padding: 10px; padding-right: 0px;" class="control-label" for="inputIcon">Поиск</label></li>
            <li>
              <div class="control-group" style="margin-bottom: 0px; padding: 5px;">
                <div class="controls">
                  <div class="input-prepend" style="margin-bottom:0px;">
                     <button class="add-on btn" style="height:29.5px" onclick="goToPage()"><i class="icon-search"></i></button>
                      <input class="span2" id="inputIcon" type="text" name="name" style="height:30px;">
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container" style="width:940px;">
      <div style="margin-bottom:10px;font-size:18px;"></span><a class="label label-important" href="cinema.php">Фильмы</a> -- <a class="label" href="directors.php">Режиссеры</a> -- <a class="label" href="actors.php">Актеры</a> -- <a class="label" href="genres.php">Жанры</a></div>
      <div class="span6" style="width:100%;margin-left:0px;">
          <div class="span6" style="width:100%; margin-bottom:20px; margin-left:0px;">
              <div class="block_content">
                <div class="content-top">
                  <div class="content-top-article">
                    Кино
                  </div>
                </div>
                <div class="content-middle">
                  <div class="content-table" >
                    <div id="formAddFilm" style="margin-top:20px;">
                      <form action="php/updateCinema.php" method="post">
                      <div style="width:400px;float:left;">
                        <table>
                          <tr>
                            <td>Название</td>
                            <td ><input type="text" name="name" value="<?php echo $name; ?>" required/></td>
                          </tr>
                           <tr>
                            <td>Дата выпуска</td>
                            <td ><input type="text" name="dateRealese" value="<?php echo $date; ?>" pattern="[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))" required/></td>
                          </tr>
                           <tr>
                            <td>Длительность</td>
                            <td ><input type="time" name="duration" style="height:30px;" value="<?php echo $duration; ?>" required/></td>
                          </tr>
                          <tr>
                            <td>Режиссер</td>
                            <td ><select style="width:206px;" name="director" required/>
                              <option><?php echo $director; ?></option>
                              <?php
                                    for($i=0;$i<count($directors);++$i)echo $directors[$i];
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Описание</td>
                            <td ><textarea name="description" required ><?php echo $description; ?></textarea></td>
                          </tr>
                          <tr>
                          <td>Категория</td>
                          <td ><input type="text" name="category" value="<?php echo $category; ?>" required/></td>
                        </tr>
                        <tr>
                          <td>Страна</td>
                          <td ><input type="text" name="country" value="<?php echo $country; ?>" required/></td>
                        </tr>
                        <tr>
                          <td ><input type="hidden" name="id" value="<?php echo $id; ?>" required/></td>
                        </tr>
                       </table>
                       <div style="width:100%;text-align: center;margin-top:20px;"><button class='btn btn-success' style="width: 250px;"><span>Применить</span></button></div>
                      </div>
                      </form> 
                      <div style="width:400px;float:left;">
                        <strong>Редактировать жанры</strong>
                        <br>
                        <table id="editGenre" style="margin:0;margin:10px 0;" class='table-h'>
                          
                          <? echo $genres ?>
                         
                        </table>
                        <strong>Редактировать актеров</strong>
                        <br>
                         <table id='editActor' style="margin:0;margin:10px 0;" class='table-h'>
                          <? echo $actors ?>
                        </table>
                        </div>
                        <div style="clear:both;"></div>
                      </div>
                    </div>

                  </div>
                  <div  class="content-bottom">
                </div>
              </div>
          </div>  <!--span6-->
      </div>  <!--span6--> 
      <div id="go_to_top" class="go_to_top" title="Наверх" style=" right: 133px; bottom: 115px;"><a href="#"><img src="../img/go_to_top_small.png"></a></div>
    </div>  <!--container-->
  </body>
</html>