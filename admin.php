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
      }
      else {
        $_SESSION['style']="css/style.css";
        $background="background-color:#FB6B0D";
        $backgroundC="backgroundColor='#FB6B0D'";
      }
    }
  }
  if(isset($_SESSION["style"])){
    if($_SESSION['style']!="css/style.css") {
         $_SESSION['style']="css/style2.css";
         $background="background-color:rgb(21, 165, 27)";
          $backgroundC="backgroundColor='rgb(21, 165, 27)'";
       }
       else{
        $_SESSION['style']="css/style.css";
        $background="background-color:#FB6B0D";
        $backgroundC="backgroundColor='#FB6B0D'";
       }
  }
if(($_POST["login"]=="admin" && $_POST["pass"]=="admin") || isset($_SESSION["login"])) {
  $_SESSION["login"]=true;
}
else header("location:login.php?error=1");

$query="Select max(id) from kino";
  if (!$result = $link->query($query)) {
    echo "error";
  }

$row=$result->fetch_row();
$max_id=$row[0]+1;
if(!empty($_POST["name"]) && !empty($_POST["country"]) && !empty($_POST["date"]) && !empty($_POST["date_adding"]) && !empty($_POST["director"]) && !empty($_POST["actor"]) && !empty($_POST["genre"]) && !empty($_POST["duration"]) && !empty($_POST["restriction"]) && !empty($_POST["description"])){
    $result=$link->query("select Продолжительность from kino where $dur_='{$_POST['duration']}'");
    $r = $result->num_rows;
    
    if($r==0){
        $msg=1;
        $name_=$_POST["name"];
        $director_=$_POST["director"];
        $country_=$_POST["country"];
        $description_=$_POST["description"];
        $link->query("insert into director values ('$director_',null,null,null)");
        if($link->query("insert into kino values ($max_id,'$name_','{$_POST["date"]}','{$_POST["date_adding"]}','{$_POST["duration"]}','$director_','$description_','{$_POST["restriction"]}','$country_')")){
        }
        else {
          $msg=2;
          exit();
        }
        for($i=0;$i<count($_POST["actor"]);++$i){
          $actor_=$_POST['actor'][$i];
          $link->query("insert into actors values ('$actor_',null,null,null)");
          $link->query("insert into actors_kino values ($max_id,'$actor_')");
        }
        for($i=0;$i<count($_POST["genre"]);++$i){
          $genre_=$_POST['genre'][$i];
          $link->query("insert into kino_genre values ('$genre_',$max_id)");
        }
        if(isset($_FILES['image'])){
          $target_path = "img/";
          $target_path = $target_path.$max_id.'.jpg'; 
          if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
              echo "The file ".basename( $_FILES['image']['name'])." has been uploaded";
          }
        }
    } 
} 

$query="select * from genre";
$cnt_genre="select count(*) from genre";
$result = $link->query($query);
$i=0;
while($row=$result->fetch_row()){

    $genres[$i]=$row[0];

    ++$i;
}
mysqli_close($link);
?>
<html>
  <head>
    <title>Кинокаталог - Администратор</title>
    <!---<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.10.1.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo $_SESSION['style'];?>" rel="stylesheet" media="screen">
    <link type="image/x-icon" rel="shortcut icon" href="img/favicon.ico">
    <script src="js/myJS.js"></script>
    <script type="text/javascript">
        function add(a){
              var g="<tr><td></td><td><select name='genre[]' id='genre' required style='height:30px; width:181px;' > <option> </option><?php for($i=0;$i<count($genres);++$i){ $genres[$i]=$genres[$i];echo '<option value='.$genres[$i].'>'.$genres[$i].'</option>';}?></select></td></tr>";
              var ac="<tr><td></td><<td><input type='text'  name='actor[]'  required style='height:30px; width:181px;'></td></tr>";
              if(a=="#add_genre"){
                $(a).after(g);
              }
              else $(a).after(ac);
        }
        
  
       </script>
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
            <li  style="margin-left: 360px;"> <label style="margin-bottom: 0px; padding: 10px; padding-right: 0px;" class="control-label" for="inputIcon">Поиск</label></li>
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
              <li><a href="last.php"> Последние добавленые </a></li>
              <li><a href="search_result.php"><i class="icon-search icon-white"> </i> Расширенный поиск</a></li>
            </ul>
      </div>
      <div class="span6" style="width:600px; ">
        <ul class="nav nav-tabs nav-stacked " >
          <li><a id="search-area-top">Добавление информации о фильме или сериале</a></li>
          <!-- <div class="span6" style="width:600px; margin-bottom:20px; margin-left:0px;"> -->
              <!-- <div class="block_content"> -->
          <li style="border:1px solid #1b1b1b; background-color:white; ">
              <div style="width:500px; margin:auto; margin-top:10px;  text-align:center; background-color:#ecf2f4; border-radius:5px;">
                  <div id="msg" style="margin:auto; margin-bottom: 10px; padding:5px;">
                    <form enctype="multipart/form-data" action="admin.php" method="post">
                      <table >
                        <tr>
                          <td><strong>Название</strong></td>
                          <td><input type="text" name="name" required></td>

                        </tr> 
                        <tr>
                          <td><strong>Страна</strong></td>
                          <td><input type="text" name="country" required style="height:30px;"></td>

                        </tr>
                        <tr>
                          <td><strong>Дата выхода</strong></td>
                          <td><input type="text" name="date" required style="height:30px;" pattern="(\d{4})\-(0\d|1[012])\-([0-2]\d|3[01])" title="Введите дату выхода в формате гггг-мм-дд"></td>

                        </tr>
                        <tr>
                          <td><strong>Дата добавления</strong></td>
                          <td><input type="text" name="date_adding" required style="height:30px;" pattern="(\d{4})\-(0\d|1[012])\-([0-2]\d|3[01])" title="Введите дату добавления в формате гггг-мм-дд"></td>

                        </tr>
                        <tr>
                          <td><strong>Режиссер</strong></td>
                          <td><input type="text" name="director" required style="height:30px;"></td>

                        </tr>
                        <tr id="add_actor">
                          <td><strong>Актер</strong></td>
                           <td>
                             <div class="control-group" >
                                <div class="controls">
                                  <div class="input-append" style="margin-bottom:0px;">
                                    <input type="text"  name="actor[]" list required style="height:30px; width:181px;">
                                    <button type="button" class="add-on btn" onclick="add('#add_actor')" style="height:29.5px"><i class="icon-plus"></i></button>
                                    </div>
                                  </div>
                                </div>
                          </td>
                        </tr> 
                        <tr id="add_genre">
                          <td><strong>Жанр</strong></td>
                          <td>
                             <div class="control-group" >
                                <div class="controls">
                                  <div class="input-append" style="margin-bottom:0px;">
                                    <!-- <input type="text"  name="genre[]" list  required style="height:30px; width:181px;"> -->
                                    <select name='genre[]' id='genre' required style='height:30px; width:181px;' >
                                       <option></option>
                                       <?php 
                                         for($i=0;$i<count($genres);++$i){ 
                                          echo "<option value='$genres[$i]'>$genres[$i]</option>";
                                         }
                                      ?>
                                    </select>
                                    <button type="button" class="add-on btn" onclick="add('#add_genre')" style="height:29.5px"><i class="icon-plus"></i></button>
                                    </div>
                                  </div>
                                </div>
                          </td>
                      
                        </tr>
                        <tr>
                          <td><strong>Продолжительность</strong></td>
                          <td><input type="time" name="duration" required style="height:30px;"></td>

                        </tr>
                        <tr>
                          <td><strong>Ограничение возраста</strong></td>
                          <td><input type="text" name="restriction" required style="height:30px;" pattern="\+[0-9]{1,2}" title="Введите ограничение возраста. Например: +16"></td>

                        </tr>
                        <tr>
                          <td style="vertical-align: top;"><strong>Описание</strong></td>
                          <td><textarea name="description" required style="height:70px;"></textarea></td>
                        </tr>
                        <tr>
                          <td><strong>Постер</strong></td>
                          <td><input  name="image" type="file" required></td>
                        </tr>
                        <tr>
                          <td colspan="2" style="text-align:center;"><input type="submit" class="btn" value=" Добавить "></td>

                        <tr>
                      </table>
                    </form>
                <!--   </div>
                </div> -->
              </div>
            </div>  <!--span6-->
          </li>
          <li><a style="background-color: #1b1b1b; border-bottom-left-radius:5px; border-bottom-right-radius:5px;">
          </li>
        </ul>
      </div> 
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
  <script type="text/javascript">
    if(<?php echo $msg;?>!=2){
          $("#msg").prepend("<div class='alert alert-success'>Данные успешно добавлены</div>");
        }
        else $("#msg").prepend("<div class='alert alert-error'>Не удалось добавить данные</div>");
  </script>
</html>