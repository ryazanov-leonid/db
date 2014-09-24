<?php
session_start();
if($_SESSION["login"]){
      $menuTables = "<script> $(\"#vertMenu\").append(\"<li class='dropdown-submenu'><a >Таблицы</a><ul class='dropdown-menu'><li><a href='tables/cinema.php'>Фильмы</a></li><li><a href='tables/directors.php'>Режиссеры</a></li><li><a href='tables/actors.php'>Актеры</a></li><li><a href='tables/genres.php'>Жанры</a></li></ul></li>\");</script>";
  }
include("php/connect_mssql_db.php");
  include('php/functions.php');
  include('php/session.php');
  $pages=ceil(getCountKino($conn)/$items);
  include('php/pagination.php');
  $result = getLastAdded($conn,$start,$end);
  include("php/content.php");
  sqlsrv_close($conn);
?>
<html>
  <head>
    <title>Кинокаталог - Последние добавленные</title>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.10.1.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style2.css" rel="stylesheet" media="screen">
    <link type="image/x-icon" rel="shortcut icon" href="img/favicon.ico">
    <script src="js/myJS.js"></script>
    <script type="text/javascript">
     function goToPage(){
      var a=$("#inputIcon").val();
      if (a !== "" && a !== "0" && a !== 0 && a !== null && a !== false && a !== "undefined")
        document.location.href="result.php?name="+a;
      }
    </script>
    
    
  </head>
  <body>
    <div class="container header_container" >
      <div style="margin:10px 15px;" >
        <div><img class="header_img" title="Железный человек 3" src="img/1.jpg"></div>
        <div><img class="header_img"  title="Побег из Шоушенка" src="img/2.jpg"></div>
        <div><img class="header_img"  title="Зеленая миля" src="img/3.jpg"></div>
        <div><img class="header_img" title="1+1" src="img/4.jpg"></div>
        <div><img class="header_img" title="Начало" src="img/5.jpg"></div>
        <div><img class="header_img" title="Иван Васильевич меняет профессию " src="img/6.jpg"></div>
        <div><img class="header_img" title="Крестный отец" src="img/7.jpg"></div>
        <div><img class="header_img" title="Легенда №17 " src="img/8.jpg"></div>
        <div><img class="header_img" title="Властелин колец: Возвращение Короля" src="img/9.jpg"></div>
        <div><img class="header_img" title="Игра престолов " src="img/11.jpg"></div>
      </div>
    </div>
    <div class="container" style="width:940px;">
      <div class="navbar navbar-inverse">
        <div class="navbar-inner">
          <ul class="nav">
            <li><a  href="index.php"><i class="icon-home icon-white"> </i> Главная</a></li>
            <li><a href="films.php">Фильмы</a></li>
            <li><a href="serials.php">Сериалы</a></li>
            <li><a href="login.php">Admin</a></li>
            <li  style="margin-left: 270px;"> <label style="margin-bottom: 0px; padding: 10px; padding-right: 0px;" class="control-label" for="inputIcon">Поиск</label></li>
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
      <div class="span3">
            <ul id="vertMenu" class="nav nav-tabs nav-stacked" >
              <li><a href="new.php"> Новинки кино</a></li>
              <li><a id="active"  href="last.php"> Последние добавленые </a></li>
            </ul>
            <div style="text-align:center; font-weight:bold; color:black;">Показывать на странице</div>
            <div class='pagination pagination-centered' style="margin-top:5px;">
              <ul>
              <li><a id="3" href='last.php?row_on_page=3'>3</a></li>
              <li><a id="5" href='last.php?row_on_page=5'>5</a></li>
              <li><a id="7" href='last.php?row_on_page=7'>7</a></li>
              </ul>
            </div>
      </div>
      <div class="span6" style="width:600px; ">
          <div class='pagination pagination-centered' style="margin-top:0px;">
            <ul>
             <?php echo $pagination ?>
            </ul>
          </div>
          <div class="span6" style="width:600px; margin-bottom:20px; margin-left:0px;">
              <div class="block_content">
                <?php echo $content ?>
              </div>
          </div>  <!--span6-->
        <div class="span6" style="width:600px;">
          <div class='pagination pagination-centered'>
            <ul>
              <?php echo $pagination ?>
            </ul>
          </div>
        </div>
      </div>  <!--span6--> 
      <div id="go_to_top" class="go_to_top" title="Наверх" style=" right: 133px; bottom: 115px;"><a href="#"><img src="img/go_to_top_small.png"></a></div>
      <div class="span9">
        <div id="info"> 
          <ul class="list_info">
            <li class="elem_list"><a href="#">Помощь</a></li>
            <li class="elem_list"><a href="#">Обратная связь</a></li>
            <li class="elem_list"><a href="#">Контакты</a></li>
            <li class="elem_list"><a href="login.php">Администратор</a></li>
            <li class="elem_list"><a href="#">Реклама на сайте</a></li>
            <li class="elem_list"><a href="#">Информация о сайте</a></li>
          </ul>
        </div>
      </div>
    </div>  <!--container-->
         <?php echo $paginationStyle; 
         echo $menuTables;
         ?>
  </body>
</html>