<?php
	session_start();
	if(($_POST["login"]=="admin" && $_POST["pass"]=="admin") || isset($_SESSION["login"])) {
	  $_SESSION["login"]=true;
	  header("location:../index.php");
	}
	else header("location:../login.php?error=1");
?>