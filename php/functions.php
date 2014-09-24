<?php
  function getResultSearch($conn,$start,$end,$name){
    $name ="'%".iconv("UTF-8","windows-1251", $name)."%'";
    $result = sqlsrv_query($conn,"exec getResultSearch $name,$start,$end");
    return $result;
  } 

  function search($conn,$name){
    $name ="'%".iconv("UTF-8","windows-1251", $name)."%'";
    $result=sqlsrv_query($conn,"exec countResult $name");
    $count=sqlsrv_fetch_array($result);
    return $count[0];

  }

  function getNewAdded($conn,$start,$end){
    $result = sqlsrv_query($conn,"exec paginationNewKino $start,$end");
      if (!$result){
        header("location:404.html");
        exit();
      }
      return $result;
  } 

  function getLastAdded($conn,$start,$end){
    $result = sqlsrv_query($conn,"exec paginationLastEddedKino $start,$end");
      if (!$result){
        header("location:404.html");
        exit();
      }
      return $result;
    } 

   function getSerials($conn,$start,$end){
    $result = sqlsrv_query($conn,"exec paginationSerials $start,$end");
      if (!$result){
        header("location:404.html");
        exit();
      }
      return $result;
    } 

  function getCountSerials($conn){
      $result=sqlsrv_query($conn,"exec getCountSerials");
      if (!$result){
        header("location:404.html");
        exit();
      }
      $count=sqlsrv_fetch_array($result);
      return $count[0];
  }

  function getFilms($conn,$start,$end){
    $result = sqlsrv_query($conn,"exec paginationFilms $start,$end");
      if (!$result){
        header("location:404.html");
        exit();
      }
      return $result;
    }

  function getCountFilms($conn){
      $result=sqlsrv_query($conn,"exec getCountFilms");
      if (!$result){
        header("location:404.html");
        exit();
      }
      $count=sqlsrv_fetch_array($result);
      return $count[0];
  }

	function getCountKino($conn){
	    $result=sqlsrv_query($conn,"exec countKino");
      if (!$result){
        echo "Не удалось получить количество фильмов";
        exit();
      }
	    $count=sqlsrv_fetch_array($result);
	    return $count[0];
	}

	function getKino($conn,$start,$end){
      $result = sqlsrv_query($conn,"exec paginationKino $start,$end");
      if (!$result){
        echo "Не удалось получить фильмы для pagination";
        exit();
      }
      return $result;
  	}
?>