<?php
while($kino=sqlsrv_fetch_array($result)){
        $row_actors=" ";
        $row_genre=" ";
        $res1=sqlsrv_query($conn,"exec getActorForKinoById $kino[0];");
         while($row = sqlsrv_fetch_array($res1)){         
          $row_actors.="<a href='#'>".iconv("windows-1251","UTF-8",$row[0])."</a>";
          $row_actors.=", ";
        }
        $row_actors=substr($row_actors,0,strlen($row_actors)-2);

        $res2=sqlsrv_query($conn,"exec getGenreForKinoById $kino[0];");
        while($row = sqlsrv_fetch_array($res2)){
          $row_genre.="<a href='#'>".iconv("windows-1251","UTF-8",$row[0])."</a>";
          $row_genre.=", ";

        }
       $row_genre=substr($row_genre,0,strlen($row_genre)-2);
        $kino[1] = iconv("windows-1251","UTF-8",$kino[1]);
        $kino[5] = iconv("windows-1251","UTF-8",$kino[5]);
        $kino[6] = iconv("windows-1251","UTF-8",$kino[6]);
        $kino[7] = iconv("windows-1251","UTF-8",$kino[7]);
        $kino[8] = iconv("windows-1251","UTF-8",$kino[8]);       
$dateRealese=$kino[2]->format('Y-m-d'); 
$year=substr($kino[2]->format('Y-m-d'),0,4); 
$duration =  $kino[4]->format('h:i:s');
$a=<<<A
 <table class="table"><tr><td style='width: 175px;'><div class="span2" style="margin-left:5px; float:left;  max-width: 170px;"><img title='$kino[1]' src="img/$kino[0].jpg" class="img-polaroid img_content"></img></div></td><td style="padding:0px"><div class="style_content"><strong> $kino[1] ($year)($kino[7]+)</strong><br><span style="font-size:12px;"><strong>Жанр:</strong> $row_genre<br><strong>Режиссер:</strong> <a href="#">$kino[5]</a><br><strong>Страна:</strong> $kino[8]<br><strong>В ролях:</strong> $row_actors<br><strong>Продолжительность:</strong> $duration<br>$kino[6]<br><span style="font-size:10px;"><strong>Дата выхода фильма:</strong> $dateRealese</span></span></div> </td></tr></table>
A;
$content.=$a; 
}
?>