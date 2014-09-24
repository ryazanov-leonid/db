<?php
if(!empty($_GET["page"])){
       $page=$_GET["page"];
   }
  else $page=1; // номер страницы в пагинации
  
  if(!empty($_GET["row_on_page"])){
    $_SESSION['row_on_page']=$_GET["row_on_page"];
  }
  if(isset($_SESSION['row_on_page'])){
    $items=$_SESSION['row_on_page'];
  }
  else $_SESSION['row_on_page']=5;   

  $items= $_SESSION['row_on_page'];  // количество сериалов/фильмов на странице поумолчанию 5

  if(!($items ==3 || $items ==5 || $items ==7)) header('location:404.html');

  $start = $page*$items-$items;  // с какого элемента выводить
  $start=$start+1;
  $end = $start+$items;
?>