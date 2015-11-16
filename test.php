<html>
<head>
<title>PHP TEST</title>
</head>
<body>

<?php

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('接続失敗です。'.mysql_error());
}

print('<p>接続に成功しました。</p>');

$db_selected = mysql_select_db('2015_natori', $link);
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}

print('<p>2015_natoriデータベースを選択しました。</p>');

mysql_set_charset('utf8');

$result = mysql_query("SELECT name FROM giin where detail='男'");
if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}

while ($row = mysql_fetch_assoc($result)) {
    print('<p>');
    
    print($row['name']);
    print('</p>');
}

$close_flag = mysql_close($link);

if ($close_flag){
    print('<p>切断に成功しました。</p>');
}

?>
</body>
</html>