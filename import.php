<?php

#table name を三ヶ所変更する必要があり

function member(){

   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web_02', 'root', 'gai0730',
             array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));#必要
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

  // ディレクトリのパスを記述
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

function bill(){

   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web_02', 'root', 'gai0730',
             array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

  // ディレクトリのパスを記述
  $dir = "/Applications/XAMPP/xamppfiles/htdocs/lp/import_folder/";
  $ctr = 0;

  // ディレクトリの存在を確認し、ハンドルを取得
  if( is_dir( $dir ) && $handle = opendir( $dir ) ) {
     while( ($file = readdir( $handle )) !== false){
        $path = scandir( $dir );
     }
        
      foreach( $path as $val ){
         $pos = strpos( $val, ".csv" );
         if( $pos === false ){
            continue;
         }else{
            $fp = fopen( $val, "r+" );#rのみだと読み込みopenなためr+にする
            $text = file_get_contents( "$val" );
            $convert = mb_convert_encoding( $text, "UTF-8", "sjis-win" );#sjis-winにする理由url:http://blog.livedoor.jp/loopus/archives/50160285.html, #iconv()もencoding関数
            fwrite( $fp, $convert );
            fclose( $fp );
         }

         $sql = "SHOW TABLES";
         $stmt = $dbh->query($sql);
         $tables = "";
         foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
            $tables .= print_r( $test_auto['Tables_in_natori_web_02'], TRUE );
         }

         $table_pos = strpos( $tables, "bill" );
         if( $table_pos === false ){
            $sql = "CREATE TABLE `bill`(
            `test0` VARCHAR(255),
            `test1` BIGINT,
            `test2` BIGINT,
            `test3` BIGINT,
            `test4` BIGINT,
            `test5` VARCHAR(255),
            `test6` VARCHAR(255),
            `test7` VARCHAR(255),
            `test8` VARCHAR(255),
            `test9` BIGINT,
            `test10` BIGINT
            ) DEFAULT CHARSET=utf8";

            $dbh->query( $sql );
            $dbh->query("LOAD DATA LOCAL INFILE '$val' INTO TABLE bill FIELDS TERMINATED BY ',' IGNORE 1 LINES");

            print_r( $val );
            echo " がimportされました!";
            echo "<br>";

          }else{
            echo "同じtableに対して2度目以上のimportのためinsertができません。";
          }
      }
   }
}

    ?>