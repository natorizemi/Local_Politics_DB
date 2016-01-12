<!DOCTYPE HTML> 
 <html lang="ja"> 
 <head> 
  <meta charset="utf-8"> 
  <title>sample1</title> 
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <link rel="stylesheet" type="text/css" href="sample1.css"> 
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
 </head> 

 <body>
<?php
$link = mysql_connect('localhost', 'root', '');

$db_selected = mysql_select_db('2015_natori', $link);
mysql_set_charset('utf8');
$ken=htmlspecialchars($_POST['selectName1']);
$shi=htmlspecialchars($_POST['selectName2']);
$jis=$ken*1000+$shi;
$jis=mb_convert_kana($jis,"a");

$result = mysql_query("SELECT name,age,sex,poli FROM giin where id like '%{$jis}%'");

$i=1;


while ($row = mysql_fetch_assoc($result)) {
$name1=htmlspecialchars($row['name']);

echo"<div class='menu'>";
    echo"<label for='Panel$i'>$name1</label>";
    echo"<input type='checkbox' id='Panel$i' class='on-off' />";
    echo"<ul>";

    echo(htmlspecialchars($row['age']));
    echo '歳';
    print('<p>');
    echo(htmlspecialchars($row['sex']));
    print('</p>');
    print('<p>');
    echo(htmlspecialchars($row['poli']));
    print('</p>');



    echo"</ul>";
    
  echo"</div>";
$i=$i+1;
}


  
  ?>
 </body>
</html>

