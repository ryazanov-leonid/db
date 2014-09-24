<?php
session_start();
if(!$_SESSION["login"]) header("Location:../login.php");
if(!empty($_GET['name'])){
  $link_add = '<script>$("#formAddFilm").css("display","block");$("#formAddFilm").fadeIn("fast", function() {$("#show").empty();$("#show").append("<a onclick=\'fadeOutAddForm()\' style=\'color:white;\'>Скрыть</a>");});</script>';
}
include("../php/connect_mssql_db.php");
  $result = sqlsrv_query($conn,"exec getCinema;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
  $content = "<table class='table-h' style='margin:0px;'>
                        <tr>
                          <td colspan='2'><strong>Действия</strong></td>
                          <td><strong>Название</strong></td>
                          <td><strong>Дата<br>выпуска</strong></td>
                          <td><strong>Дата<br>добавления</strong></td>
                          <td><strong>Длит-сть</strong></td>
                          <td><strong>Режиссер</strong></td>
                          <td ><strong>Описание</strong></td>
                          <td><strong>Категория</strong></td>
                          <td><strong>Страна</strong></td>
                        </tr>";    
  while($row = sqlsrv_fetch_array($result)){
        $row[1] = iconv("windows-1251","UTF-8",$row[1]);
        $row[5] = iconv("windows-1251","UTF-8",$row[5]);
        $row[6] = iconv("windows-1251","UTF-8",$row[6]);
        $row[7] = iconv("windows-1251","UTF-8",$row[7]);
        $row[8] = iconv("windows-1251","UTF-8",$row[8]);
        $content .= '<tr>
                            <td style="width:50px"><button onclick="edit('.$row[0].')"><i class="icon-pencil"></button></td>
                            <td style="width:50px"><button onclick="deleteCinema('.$row[0].')"><i class="icon-remove"></button></td>
                            <td class="fontSize">'.$row[1].'</td>
                            <td class="fontSize">'.$row[2]->format('Y-m-d').'</td>
                            <td class="fontSize">'.$row[3]->format('Y-m-d').'</td>
                            <td class="fontSize">'.$row[4]->format('h:i:s').'</td>
                            <td class="fontSize">'.$row[5].'</td>
                            <td class="fontSize"><div style="height:70px;overflow: auto;">'.$row[6].'</div></td>
                            <td class="fontSize">'.$row[7].'+</td>
                            <td class="fontSize">'.$row[8].'</td>
                          </tr>';
  }


  $content.="
          </table>";
  $result = sqlsrv_query($conn,"exec getGenres;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $genres="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $genres[$i]="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
    ++$i;
  }
  $result = sqlsrv_query($conn,"exec getActors;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $actors="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $actors[$i]="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
    ++$i;
  }
  $result = sqlsrv_query($conn,"exec getDirectors;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $directors="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $directors[$i]="<option>".iconv("windows-1251","UTF-8",$row[0])."</option>";
    ++$i;
  }                
sqlsrv_close($conn);
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Кинокаталог - Таблица "Режиссеры"</title>
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
    function isValidDate(date){
          return /[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))/img.test(date);
    }
    function addCinema(){
      var name = $("#addName").val();
      var date = $("#addDate").val();
      var country = $("#addCountry").val();
      var gender = $("#gender").val();
      if(!isEmpty(name) && isValidDate(date) && !isEmpty(country) && !isEmpty(gender)){
        $.post("php/addCinema.php",{"name":name,"date":date,"country":country,"gender":gender},function(data){
          if(data!="error") document.location.href="cinema.php";
            else alert("Ошибка добавления");
        })
      }
      else alert("Заполните корректно поля!!!");
    }
    function deleteCinema(id){
      $.post("php/deleteCinema.php",{"id":id},function(data){
            if(data!="error") document.location.href="cinema.php";
            else alert("Ошибка удаления");
        });
    }
    function delItem(item){
      $(item).remove();
    }  
    countItem=0;
    function addInput(a){
              var g="<tr id='item"+countItem+"'><td></td><td><div class='control-group' ><div class='controls'><div class='input-append' style='margin-bottom:0px;'><select name='genres[]' required style='height:30px; width:181px;'><option></option><?php for($i=0;$i<count($genres);++$i)echo $genres[$i];?>
                </select><button type='button' class='add-on btn' onclick=\"delItem('#item"+countItem+"')\" style='height:29.5px'><i class='icon-remove'></i></button></div></div></div></td></tr>";
              var ac="<tr id='item"+countItem+"'><td></td><td><div class='control-group' ><div class='controls'><div class='input-append' style='margin-bottom:0px;'><select name='actors[]' required style='height:30px; width:181px;'><option></option><?php for($i=0;$i<count($actors);++$i)echo $actors[$i]; ?></select><button type='button' class='add-on btn' onclick=\"delItem('#item"+countItem+"')\" style='height:29.5px'><i class='icon-remove'></i></button></div></div></div></td></tr>";
              if(a=="#add_genre"){
                $(a).after(g);
              }
              else $(a).after(ac);
              ++countItem;
        }
    function fadeInAddForm(){
      $("#formAddFilm").fadeIn('fast', function() {
        $("#show").empty();
        $("#show").append('<a onclick="fadeOutAddForm()" style="color:white;">Скрыть</a>');
      });

    }
    function fadeOutAddForm(){
      $("#formAddFilm").fadeOut('fast', function() {
        $("#show").empty();
        $("#show").append('<a onclick="fadeInAddForm()" style="color:white;">Добавить</a>');
      });

    }
    function edit(id){
      document.location.href = "editcinema.php?item="+id;
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
                    <div style="">
                      <?php echo $content ?>
                    </div>
                    
                    <div id="formAddFilm" style="margin-top:20px;display:none;">
                      <form enctype="multipart/form-data" action="php/addCinema.php" method="post">
                      <div style="width:400px;float:left;">
                        <table>
                          <tr>
                            <td>Название</td>
                            <td ><input type="text" name="name" value='<?php echo $_GET["name"]; ?>' required/></td>
                          </tr>
                           <tr>
                            <td>Дата выпуска</td>
                            <td ><input type="text" name="dateRealese" pattern="[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))" required/></td>
                          </tr>
                           <tr>
                            <td>Длительность</td>
                            <td ><input type="time" name="duration" value='<?php echo $_GET["duration"]; ?>' style="height:30px;" required/></td>
                          </tr>
                          <tr>
                            <td>Режиссер</td>
                            <td ><select style="width:206px;"  name="director" required/>
                              <option><?php echo $_GET["director"]; ?></option>
                              <?php
                                    for($i=0;$i<count($directors);++$i)echo $directors[$i];
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Описание</td>
                            <td ><textarea name="description" required ><?php echo $_GET["description"]; ?></textarea></td>
                          </tr>
                       </table>
                      </div> 
                      <div style="width:400px;float:left;">
                        <table>
                        <tr>
                          <td>Категория</td>
                          <td ><input type="text" name="category" value='<?php echo $_GET["category"]; ?>' required/></td>
                        </tr>
                        <tr>
                          <td>Страна</td>
                          <td ><input type="text" name="country" value='<?php echo $_GET["country"]; ?>' required/></td>
                        </tr>
                        <tr id="add_actor">
                          <td>Актеры</td>
                             <td>
                               <div class="control-group" >
                                  <div class="controls">
                                    <div class="input-append" style="margin-bottom:0px;">
                                      <select name="actors[]" required style="height:30px; width:181px;">
                                        <option><?php echo $_GET["actor"]; ?></option>
                                        <?php
                                             for($i=0;$i<count($actors);++$i)echo $actors[$i];
                                        ?>
                                      </select>
                                      <button type="button" class="add-on btn" onclick="addInput('#add_actor')" style="height:29.5px"><i class="icon-plus"></i></button>
                                      </div>
                                    </div>
                                  </div>
                            </td>
                          </tr> 
                          <tr id="add_genre">
                            <td>Жанры</td>
                            <td>
                               <div class="control-group" >
                                  <div class="controls">
                                    <div class="input-append" style="margin-bottom:0px;">
                                      <select name='genres[]' required style='height:30px; width:181px;' >
                                         <option><?php echo $_GET["genre"]; ?></option>
                                         <?php
                                          for($i=0;$i<count($genres);++$i)echo $genres[$i];
                                         ?>
                                      </select>
                                      <button type="button" class="add-on btn" onclick="addInput('#add_genre')" style="height:29.5px"><i class="icon-plus"></i></button>
                                      </div>
                                    </div>
                                  </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Постер</td>
                            <td><input  name="image" type="file" accept="image/jpeg" required></td>
                          </tr>
                          </table>
                        </div>
                        <div style="clear:both;"></div>
                        <div style="width:100%;text-align: center;margin-top:20px;"><button class='btn btn-success' onclick='' style="width: 250px;"><span>Добавить</span></button></div> 
                      </div>
                     </form>
                     <div id="show" style="width:100px;background-color:#51a351;text-align:center;color:white;margin-top:20px;"><a onclick="fadeInAddForm()" style="color:white;">Добавить</a></div>
                    </div>

                  </div>
                  <div  class="content-bottom">
                </div>
              </div>
          </div>  <!--span6-->
      </div>  <!--span6--> 
      <div id="go_to_top" class="go_to_top" title="Наверх" style=" right: 133px; bottom: 115px;"><a href="#"><img src="../img/go_to_top_small.png"></a></div>
    </div>  <!--container-->
    <?php echo $link_add; ?>
  </body>
</html>