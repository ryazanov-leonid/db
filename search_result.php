<?php
session_start();

$link = new mysqli("localhost", "root", "", "kinocatalog");
if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if(!empty($_GET["style"])){
    if(isset($_SESSION['style'])) {
      if($_SESSION['style']=="css/style.css") {
        $_SESSION['style']="css/style2.css";
        $background="background-color:rgb(21, 165, 27)";
        $backgroundC="backgroundColor='rgb(21, 165, 27)'";
        $boxBorder = "2px solid rgb(21, 165, 27)";
        $boxSd =".btn-inverse.btn:hover {-webkit-box-shadow: -1px 0px 15px rgb(21, 165, 27);box-shadow: -1px 0px 15px rgb(21, 165, 27);}";
      }
      else {
        $_SESSION['style']="css/style.css";
        $background="background-color:#FB6B0D";
        $backgroundC="backgroundColor='#FB6B0D'";
        $boxBorder = "2px solid #FB6B0D;";
      }
    }
  }
  if(isset($_SESSION["style"])){
    if($_SESSION['style']!="css/style.css") {
         $_SESSION['style']="css/style2.css";
         $background="background-color:rgb(21, 165, 27)";
          $backgroundC="backgroundColor='rgb(21, 165, 27)'";
          $boxBorder = "2px solid rgb(21, 165, 27)";
          $boxSd =".btn-inverse.btn:hover {-webkit-box-shadow: -1px 0px 15px rgb(21, 165, 27);box-shadow: -1px 0px 15px rgb(21, 165, 27);}";
       }
       else{
        $_SESSION['style']="css/style.css";
        $background="background-color:#FB6B0D";
        $backgroundC="backgroundColor='#FB6B0D'";
        $boxBorder = "2px solid #FB6B0D;";
       }
  }
$query="select * from genre";
$result = $link->query($query);
  $i=0;
while($row=$result->fetch_row()){
    $genres[$i]=$row[0];
    ++$i;
}
$query="select distinct Страна from kino";
$result = $link->query($query);
$i=0;
if (!$result) {
  echo "error";
     exit();
  }
while($row=$result->fetch_row()){
    $countries[$i]=$row[0];
    ++$i;
}

include("search.php");
if(!empty($_GET["page"])){
       $cnt=$_GET["page"];
   }
   else $cnt=1;
  $cnt_on_page=$_SESSION['row_on_page'];
   $cnt_write=5;
  $start = $cnt*$cnt_on_page-$cnt_on_page;
  $query="select * from kino where id=Any(select distinct id from (kino join kino_genre on kino.id=kino_genre.id_kino) join actors_kino on id=actors_kino.id_kino $condition) LIMIT $start,$cnt_on_page";
$result = $link->query($query);


  $i=1;
  $cnt_row=$link->query("select count(*) from kino where id=Any(select distinct id from (kino join kino_genre on kino.id=kino_genre.id_kino) join actors_kino on id=actors_kino.id_kino $condition)");
  $res=$cnt_row->fetch_row();
  $cnt_page=ceil($res[0]/$cnt_on_page);
  $content_page="<div class='pagination pagination-centered'><ul>";
  for($i=1;$i<=$cnt_page;++$i){
      $content_page.="<li><a class='page$i' href='search_result.php?page=$i&$get_page'>$i</a></li>";

  }
 
  $content_page.="</ul></div>";
  $content="<div style='margin:5px; color:red; margin-bottom:10px;'><strong>Результатов: $res[0]</strong></div>";
  $session="<script>var id=document.getElementById('$cnt_on_page'); id.style.$backgroundC; id=document.getElementsByClassName('page'+$cnt);id[0].style.$backgroundC;id[1].style.$backgroundC;</script>";
  include("content.php");
mysqli_close($link);
?>
<html>
  <head>
    <title>Кинокаталог - расширенный поиск</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.10.1.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo $_SESSION['style'];?>" rel="stylesheet" media="screen">
    <link type="image/x-icon" rel="shortcut icon" href="img/favicon.ico">
    <script src="js/myJS.js"></script>
    <style type="text/css">
      <?php echo $boxSd?>
    </style>
    <script type="text/javascript">
    function goToPage(){
      document.location.href="search_result.php?name="+$("#inputIcon").val()+"&country=Страна&genre=Жанр&from=не важно&to=не важно";
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
      <div class="span3">
            <ul class="nav nav-tabs nav-stacked" >
              <li><a href="new.php"> Новинки кино</a></li>
              <li><a href="last.php"> Последние добавленные </a></li>
              <li><a style="<?php echo $background?>"  href="search_result.php"><i class="icon-search icon-white"> </i> Расширенный поиск</a></li>
            </ul>
              <div style="text-align:center; font-weight:bold; color:black;">Показывать на странице</div>
        <div class='pagination pagination-centered' style="margin-top:5px;">
          <ul>
          <li><a id="3" >3</a></li>
          <li><a id="5" >5</a></li>
          <li><a id="7" >7</a></li>
        </ul></div>
      </div>
      <div class="span6" style="width:600px;">
        <form action="search_result.php" method="post">
         <ul class="nav nav-tabs nav-stacked " >
          
              <li><a id="search-area-top">Параметры поиска</a></li>
              <li style="height:200px;border:1px solid #1b1b1b; background-color:white;">
                <div style="padding:10px; text-align:left;">
                  
                    <div class="span3">
                    <strong>Поиск по названию</strong><br>
                    <input type="text" id="name" name="name"><br>
                    <strong>Поиск по актеру</strong><br>
                    <input type="text" id="actor" name="actor"><br>
                    <strong>Поиск по режиссеру</strong><br>
                    <input type="text" id="director" name="director"><br>
                  </div>
                  <div class="span3">
                    <strong>Страна</strong><br>
                    <select name="country" id="country">
                      <option>Страна</option>
                      <?php 
                        for($i=0;$i<count($countries);++$i){
                          echo "<option value='$countries[$i]'>$countries[$i]</option>";
                        }
                      ?>
                    </select>
                    <br>
                     <strong>Жанр</strong><br>
                    <select name="genre" id="genre" >
                      <option>Жанр</option>
                      <?php 
                        for($i=0;$i<count($genres);++$i){
                          echo "<option value='$genres[$i]'>$genres[$i]</option>";
                        }
                      ?>
                    </select><br>
                    <strong>Дата выхода</strong><br>
                     <select name="from" id="from" style="width:100px;"> 
                      <option>не важно</option>
                      <?php 
                        for($i=2013;$i>1968;--$i){
                          echo "<option value='$i'>$i</option>";
                        }
                      ?>
                     </select>
                      <select name="to"id="to" style="width:100px;"> 
                      <option>не важно</option>
                      <?php 
                        for($i=2013;$i>1968;--$i){
                          echo "<option value='$i'>$i</option>";
                        }
                      ?>
                      </select>
                   
                    </div>
                 
                </div>

              </li>
              <li><a style="background-color: #1b1b1b;"><input style="margin-top:0px; width:200px; border:<?php echo $boxBorder?>"type="submit" class="btn btn-inverse" value=" Искать "></a></li>
            </ul>
          </form>
        <?php echo $content_page ?>
            <div class="span6" style="width:600px; margin-bottom:20px; margin-left:0px;">
              
              <div class="block_content">
                
                <?php echo $content ?>
              </div>
            </div>  <!--span6-->
        <?php echo $content_page ?>
      </div>  <!--span6--> 
  <script type="text/javascript">
      <?php 
        echo $script_content;
      ?>
    </script>
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
    <?php echo $session; ?>
  </body>
</html>
