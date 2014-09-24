<?php
$t=0;
$k=0;
$script_content="";
$condition="where ";
$get_page="";
if(!empty($_REQUEST["name"])){
  $get_page.="name={$_REQUEST['name']}";
  $script_content.="$('#name').val('{$_REQUEST['name']}');";
  $condition.="Название like ('%".$_REQUEST["name"]."%')";
  $t=1;

}
if(!empty($_REQUEST["actor"])){
  $script_content.="$('#actor').val('{$_REQUEST['actor']}');";
  if($t==1){
    $condition.=" and FIO like ('%".$_REQUEST["actor"]."%')";
    $get_page.="&actor={$_REQUEST['actor']}";
  }
  else {
    $condition.="FIO like ('%".$_REQUEST["actor"]."%')";
    $get_page.="actor={$_REQUEST['actor']}";
    $t=1;
  }

}

if(!empty($_REQUEST["director"])){
  $script_content.="$('#director').val('{$_REQUEST['director']}');";
  if($t==1){
    $condition.=" and Режиссер like ('%".$_REQUEST["director"]."%')";
    $get_page.="&director={$_REQUEST['director']}";
  }
  else {
    $condition.="Режиссер like ('%".$_REQUEST["director"]."%')";
    $get_page.="director={$_REQUEST['director']}";
    $t=1;
  }
}
if(!empty($_REQUEST["country"])){
  if($_REQUEST["country"]!="Страна"){
    $script_content.="$('#country').val('{$_REQUEST['country']}');";
    if($t==1){
      $condition.=" and Страна like ('%".$_REQUEST["country"]."%')";
      $get_page.="&country={$_REQUEST['country']}";
    }
    else {
      $condition.="Страна like ('%".$_REQUEST["country"]."%')";
      $get_page.="country={$_REQUEST['country']}";
      $t=1;
    }
  }
else if($t==1) $get_page.="&country=Страна";
    else {
      $get_page.="country=Страна";
      $k=1;
    }
}

if($_REQUEST["genre"]!="Жанр" && !empty($_REQUEST["genre"])){
  $script_content.="$('#genre').val('{$_REQUEST['genre']}');";
  if($t==1){
    $condition.=" and genre='".$_REQUEST["genre"]."'";
    $get_page.="&genre={$_REQUEST['genre']}";
  }
  else { 
    $condition.="genre='".$_REQUEST["genre"]."'";
    $get_page.="genre={$_REQUEST['genre']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&genre=Жанр";
    else  { 
      $get_page.="genre=Жанр";
      $k=1;
    }

  }
if($_REQUEST["from"]!="не важно" && !empty($_REQUEST["from"])){
  $date=$_REQUEST["from"]."-01-01";
  $script_content.="$('#from').val('{$_REQUEST['from']}');";
  if($t==1){
    $condition.=" and Дата_выхода>='".$date."'";
    $get_page.="&from={$_REQUEST['from']}";
  }
  else {
    $condition.="Дата_выхода>='".$date."'";
    $get_page.="from={$_REQUEST['from']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&from=не важно";
    else   {
      $get_page.="from=не важно";
      $k=1;
    }
  }
if($_REQUEST["to"]!="не важно" && !empty($_REQUEST["to"])){
  $date=$_REQUEST["to"]."-12-31";
  $script_content.="$('#to').val('{$_REQUEST['to']}');";
  if($t==1){
    $condition.=" and Дата_выхода<='".$date."'";
    $get_page.="&to={$_REQUEST['to']}";
  }
  else{
    $condition.="Дата_выхода<='".$date."'";
    $get_page.="to={$_REQUEST['to']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&to=не важно";
    else  {
      $get_page.="to=не важно";
      $k=1;
    }
  }

if($t==0) $condition="";
else $get_page.="&";
?>