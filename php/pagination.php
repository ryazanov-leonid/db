<?php
	$name = pathinfo($_SERVER['SCRIPT_FILENAME']);
	if($page>$pages || $page<=0) header('location:404.html');
	$n='';
	if(!empty($_GET['name']))$n='&name='.$_GET['name'];
	for($i=1;$i<=$pages;++$i){
     	 $pagination.="<li><a class='page$i' href='{$name['basename']}?page=$i".$n."'>$i</a></li>";
  	}
  	$paginationStyle="<script>var id=document.getElementById('$items'); id.style.backgroundColor = 'rgb(21, 165, 27)'; id=document.getElementsByClassName('page'+$page);id[0].style.backgroundColor = 'rgb(21, 165, 27)' ;id[1].style.backgroundColor = 'rgb(21, 165, 27)' ;</script>";
?>