<html>
<head>
<title>PHP TEST</title>
</head>
<body>



<?php

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    //die('接続失敗です。'.mysql_error());
}

//rint('<p>接続に成功しました。</p>');

$db_selected = mysql_select_db('2015_natori', $link);
if (!$db_selected){
   //die('データベース選択失敗です。'.mysql_error());
}

//print('<p>2015_natoriデータベースを選択しました。</p>');

mysql_set_charset('utf8');
$ken=htmlspecialchars($_POST['selectName1']);
$shi=htmlspecialchars($_POST['selectName2']);
$jis=$ken*1000+$shi;
$jis=mb_convert_kana($jis,"a");



//print('<p>');
//echo $ken;
//print('</p>');
//print('<p>');
//echo $shi;
//print('</p>');
//print('<p>');
//echo $jis;
//print('</p>');

$result = mysql_query("SELECT name FROM giin where id like '%{$jis}%'");
if (!$result) {
    //die('クエリーが失敗しました。'.mysql_error());
}

?>

<form name="form1" method="post" action="test1.php">
<?php
while ($row = mysql_fetch_assoc($result)) {
	$name=$row['name'];
 	
 	print('<p>');

 	echo "<td>
	<a href='javascript:document.form.submit();' ></a>
 	<input type='submit' name='name' value='$name'>
 	</td>";
 	echo "<tr>";

	print('</p>');
	
}
?>
</form>


<?php
$close_flag = mysql_close($link);

if ($close_flag){
    //print('<p>切断に成功しました。</p>');
}

?>

</body>
</html> 
