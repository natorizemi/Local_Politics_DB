<?php

function member(){

   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web_02', 'root', 'gai0730',
             array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

	// ディレクトリのパスを記述
	#$dir = "/Users/Akira/Desktop/test/";
	$dir = "/Applications/XAMPP/xamppfiles/htdocs/lp/import_folder/";
  $ctr = 0;

	// ディレクトリの存在を確認し、ハンドルを取得
	if( is_dir( $dir ) && $handle = opendir( $dir ) ) {
        while( ($file = readdir( $handle )) !== false){
           $path = scandir( $dir );
        }
        print_r( $path );
        echo "<br>";
        $path = array_slice( $path, 3 );
        foreach( $path as $val ){
           $fp = fopen( $val, "r" );
           print_r( $val );
           echo "<br>";



        $sql = "CREATE TABLE `member`(
        `test0` BIGINT primary key,
        `test1` INT,
        `test2` VARCHAR(2555),
        `test3` VARCHAR(2555),
        `test4` INT,
        `test5` INT,
        `test6` VARCHAR(255),
        `test7` INT,
        `test8` VARCHAR(255),
        `test9` VARCHAR(255),
        `test10` VARCHAR(255),
        `test11` VARCHAR(255),
        `test12` VARCHAR(255),
        `test13` VARCHAR(255),
        `test14` VARCHAR(255)
        ) DEFAULT CHARSET=utf8";

   $dbh->query( $sql );
   $dbh->query("LOAD DATA LOCAL INFILE '$val' INTO TABLE member FIELDS TERMINATED BY ','");

           /*while( !feof( $fp )){
              $line = fgets( $fp );
              #print_r( $line );
              #echo "<br>";
           }*/
        }
	}

    fclose( "$fp" );
}

    ?>