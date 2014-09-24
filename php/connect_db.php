<?php 
$link = new mysqli("localhost", "root", "", "kinocatalog");
if (!$link) {
	header("location:404.html");
    exit();
}
$link->set_charset("utf8");
?>