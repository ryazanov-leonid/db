<?php
$t=0;
$k=0;
$script_content="";
$condition="where ";
$get_page="";
if(!empty($_REQUEST["name"])){
  $get_page.="name={$_REQUEST['name']}";
  $script_content.="$('#name').val('{$_REQUEST['name']}');";
  $condition.=iconv("CP1251", "UTF-8","��������")." like ('%".iconv("CP1251", "UTF-8",$_REQUEST["name"])."%')";
  $t=1;

}
if(!empty($_REQUEST["actor"])){
  $script_content.="$('#actor').val('{$_REQUEST['actor']}');";
  if($t==1){
    $condition.=" and FIO like ('%".iconv("CP1251", "UTF-8",$_REQUEST["actor"])."%')";
    $get_page.="&actor={$_REQUEST['actor']}";
  }
  else {
    $condition.="FIO like ('%".iconv("CP1251", "UTF-8",$_REQUEST["actor"])."%')";
    $get_page.="actor={$_REQUEST['actor']}";
    $t=1;
  }

}

if(!empty($_REQUEST["director"])){
  $script_content.="$('#director').val('{$_REQUEST['director']}');";
  if($t==1){
    $condition.=" and ".iconv("CP1251", "UTF-8","��������")." like ('%".iconv("CP1251", "UTF-8",$_REQUEST["director"])."%')";
    $get_page.="&director={$_REQUEST['director']}";
  }
  else {
    $condition.=iconv("CP1251", "UTF-8","��������")." like ('%".iconv("CP1251", "UTF-8",$_REQUEST["director"])."%')";
    $get_page.="director={$_REQUEST['director']}";
    $t=1;
  }
}
if(!empty($_REQUEST["country"])){
  if($_REQUEST["country"]!="������"){
    $script_content.="$('#country').val('{$_REQUEST['country']}');";
    if($t==1){
      $condition.=" and ".iconv("CP1251", "UTF-8","������")." like ('%".iconv("CP1251", "UTF-8",$_REQUEST["country"])."%')";
      $get_page.="&country={$_REQUEST['country']}";
    }
    else {
      $condition.=iconv("CP1251", "UTF-8","������")." like ('%".iconv("CP1251", "UTF-8",$_REQUEST["country"])."%')";
      $get_page.="country={$_REQUEST['country']}";
      $t=1;
    }
  }
else if($t==1) $get_page.="&country=������";
    else {
      $get_page.="country=������";
      $k=1;
    }
}

if($_REQUEST["genre"]!="����" && !empty($_REQUEST["genre"])){
  $script_content.="$('#genre').val('{$_REQUEST['genre']}');";
  if($t==1){
    $condition.=" and genre='".iconv("CP1251", "UTF-8",$_REQUEST["genre"])."'";
    $get_page.="&genre={$_REQUEST['genre']}";
  }
  else { 
    $condition.="genre='".iconv("CP1251", "UTF-8",$_REQUEST["genre"])."'";
    $get_page.="genre={$_REQUEST['genre']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&genre=����";
    else  { 
      $get_page.="genre=����";
      $k=1;
    }

  }
if($_REQUEST["from"]!="�� �����" && !empty($_REQUEST["from"])){
  $date=$_REQUEST["from"]."-01-01";
  $script_content.="$('#from').val('{$_REQUEST['from']}');";
  if($t==1){
    $condition.=" and ".iconv("CP1251", "UTF-8","����_������").">='".iconv("CP1251", "UTF-8",$date)."'";
    $get_page.="&from={$_REQUEST['from']}";
  }
  else {
    $condition.=iconv("CP1251", "UTF-8","����_������").">='".iconv("CP1251", "UTF-8",$date)."'";
    $get_page.="from={$_REQUEST['from']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&from=�� �����";
    else   {
      $get_page.="from=�� �����";
      $k=1;
    }
  }
if($_REQUEST["to"]!="�� �����" && !empty($_REQUEST["to"])){
  $date=$_REQUEST["to"]."-12-31";
  $script_content.="$('#to').val('{$_REQUEST['to']}');";
  if($t==1){
    $condition.=" and ".iconv("CP1251", "UTF-8","����_������")."<='".iconv("CP1251", "UTF-8",$date)."'";
    $get_page.="&to={$_REQUEST['to']}";
  }
  else{
    $condition.=iconv("CP1251", "UTF-8","����_������")."<='".iconv("CP1251", "UTF-8",$date)."'";
    $get_page.="to={$_REQUEST['to']}";
    $t=1;
  }
}
else {
  if($t==1 || $k=1) $get_page.="&to=�� �����";
    else  {
      $get_page.="to=�� �����";
      $k=1;
    }
  }

if($t==0) $condition="";
else $get_page.="&";
?>