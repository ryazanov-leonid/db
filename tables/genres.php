<?php
session_start();
if(!$_SESSION["login"]) header("Location:../login.php");
include("../php/connect_mssql_db.php");
  
  $result = sqlsrv_query($conn,"exec getGenres;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
  $i=0;    
  $content = "<table id='genres' class='table-h'>
                        <tr>
                          <td colspan='2'> <strong>Действия </strong></td>
                          <td><strong> Название </strong></td>
                          <td><strong> Кол-во фильмов </strong></td>
                        </tr>";    
  while($row = sqlsrv_fetch_array($result)){
      $row[0] = iconv("windows-1251","UTF-8",$row[0]);
      $row[1] = iconv("windows-1251","UTF-8",$row[1]);
      $content .= '<tr>
                          <td id="update'.$i.'"" style="width:50px"><button onclick="updateGenre(\''.$row[0].'\',\''.$i.'\')"><i class="icon-pencil"></button></td>
                          <td style="width:50px"><button onclick="deleteGenre(\''.$row[0].'\')"><i class="icon-remove"></button></td>
                          <td id="'.$i.'">'.$row[0].'</td>
                          <td>'.$row[1].'</td>
                        </tr>';
      ++$i;
  }
  $content.="</table>";
sqlsrv_close($conn);
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Кинокаталог - Таблица "Жанры"</title>
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
    function addGenre(){
        var a=$("#addGenre").val();
        if(!isEmpty(a)){
          $.post('php/addGenre.php', {genre: a}, function(data) {
            if(data) document.location.href="genres.php";
            else alert("Ошибка добавления");
          });
        }
        else alert("Введите жанр!");
    }
    function deleteGenre(genre){
      $.post("php/deleteGenre.php",{"genre":genre},function(data){
            if(data!="error") document.location.href="genres.php";
            else alert("Ошибка удаления");
        });
    }
    function updateGenre(genre,td){
        var textCell = document.getElementById(td).innerText;
        $("#update"+td).replaceWith('<td><button onclick="saveGenre(\''+genre+'\')"><i class="icon-ok"></button></td>');
        $("#"+td).replaceWith('<td><input id="update'+genre+'" type="text" value="'+textCell+'"/></td>');
    }
    function saveGenre(genre){
      if(!isEmpty($("#update"+genre).val())){
        $.post('php/updateGenre.php', {"genre":genre,"value":$("#update"+genre).val()},function(data){
          if(data!="error") document.location.href="genres.php";
            else alert("Ошибка обновления!");
        });
      }
      else alert("Заполните поле!");
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
            <li  style="margin-left: 370px;"> <label style="margin-bottom: 0px; padding: 10px; padding-right: 0px;" class="control-label" for="inputIcon">Поиск</label></li>
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
      <div class="span3" style="width:200px;max-width:200px;min-width:200px;">
            <ul id="vertMenu" class="nav nav-tabs nav-stacked" >
              <li><a href="../new.php"> Новинки кино</a></li>
              <li><a href="../last.php"> Последние добавленые </a></li>
              <li class="dropdown-submenu">
                  <a >Таблицы</a>
                  <ul class="dropdown-menu">
                   <li><a href="cinema.php">Фильмы</a></li>
                   <li><a href="directors.php">Режиссеры</a></li>
                   <li><a href="actors.php">Актеры</a></li>
                   <li><a href="genres.php">Жанры</a></li>
                  </ul>
                </li>
            </ul>
      </div>
      <div class="span6" style="width:720px; margin-left:20px;">
          <div class="span6" style="width:100%; margin-bottom:20px; margin-left:0px;">
              <div class="block_content">
                <div class="content-top">
                  <div class="content-top-article">
                    Жанры
                  </div>
                </div>
                <div class="content-middle">
                  <div class="content-table">
                    <div style="width:300px; float:left;">
                      <?php echo $content ?>
                    </div>
                    <div class="add" style="width:300px;float:left;">
                      <table>
                        <tr>
                          <td><input type="text" name="addGenre" id="addGenre" placeholder="Жанр" style="margin:0"/></td>
                          <td><button class="btn btn-success" onclick="addGenre()"> Добавить </button></td>
                        </tr>
                        <!-- <tr>
                          <td></td>
                          <td><button class="btn btn-danger"> Удалить<br>отмеченные </button></td>
                        </tr> -->
                      </table>
                    </div>
                    <div style="clear:both;"></div>
                  </div>
                </div>
                <div  class="content-bottom">
                  
                </div>
              </div>
          </div>  <!--span6-->
      </div>  <!--span6--> 
      <div id="go_to_top" class="go_to_top" title="Наверх" style=" right: 133px; bottom: 115px;"><a href="#"><img src="../img/go_to_top_small.png"></a></div>
    </div>  <!--container-->
     <?php
                echo $menuTables;
          ?>
  </body>
</html>