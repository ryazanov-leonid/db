<?php
session_start();
$error="";
if(isset($_GET["error"])){
  $error = true;

}
if(isset($_SESSION["login"])) header("location:index.php");
?>
<html>
  <head>
    <title>Кинокаталог - Авторизация</title>
     <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style2.css" rel="stylesheet" media="screen">
    <link type="image/x-icon" rel="shortcut icon" href="img/favicon.ico">
    <script src="js/myJS.js"></script>
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
            <li><a href="index.php"><i class="icon-home icon-white"> </i> Главная</a></li>
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
            <ul class="nav nav-tabs nav-stacked" >
              <li><a href="new.php"> Новинки кино</a></li>
              <li><a href="last.php"> Последние добавленные </a></li>
            </ul>
      </div>
      <div class="span6" style="width:600px; ">
        <ul class="nav nav-tabs nav-stacked " >
          <li><a id="search-area-top">Ввелите логин и пароль администратора</a></li>
          <li style="border:1px solid #1b1b1b; background-color:white; ">
              <div id="er" style="width:300px;  margin:auto; margin-top:10px;  text-align:center; background-color:#ecf2f4; border-radius:5px;">
                
                  <div  style="width:206px;  margin:auto; padding:15px 5px; margin-bottom:10px;">
                    <form action="php/admin.php" method="post" >
                    Логин<br>
                    <input type="text" id="login" name="login" required><br>
                    Пароль <br>
                    <input type="password" id="pass" name="pass" required style="height:30px;"><br>
                    <input class="btn" style="margin-top: 10px;" type="submit" value=" Войти "><br>
                  </form>
              </div>
            </div>  <!--span6-->
          </li>
          <li><a style="background-color: #1b1b1b; border-bottom-left-radius:5px; border-bottom-right-radius:5px;">
          </li>
        </ul>
      </div> 
    </div>  <!--container-->
         <?php echo $session; ?>
  </body>
  <script type="text/javascript">
      if(<?php echo $error?>==1){
        $("#er").prepend("<div class='alert alert-error' style='margin-bottom:0px;'>Неправильный пароль или логин</div>");
      }
    </script>
</html>