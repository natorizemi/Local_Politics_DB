<?php
   


   //処理

#議員出力function
   function member (){

   /////db処理/////
   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web', 'root', 'gai0730');
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

      $result = $_POST['search'];
      if( empty( $result ) ) {
         echo "type word!";
      }

      $sql = "SELECT * FROM people_info";
      $stmt = $dbh->query($sql);
      foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
         $name = print_r($test_auto['name'], TRUE);

         if(( strpos($name, $result)) !== false ){
            print_r( $name );
            echo "<br>";
         }
      }
      $dbh = null;
   }

#議案出力function
   function bill (){

   /////db処理/////
   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web', 'root', 'gai0730');
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

      $result = $_POST['search'];
      if( empty( $result ) ) {
         echo "type word!";
      }

      $sql = "SELECT * FROM proxy_statement";
      $stmt = $dbh->query($sql);
      foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
         $detail = print_r($test_auto['detail'], TRUE);

         if(( strpos($detail, $result)) !== false ){
            print_r( $detail );
            echo "<br>";
         }
      }
      $dbh = null;
   }

#複合検索function
   function top (){

   /////db処理/////
   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web', 'root', 'gai0730');
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

      $result = $_POST['search'];
      if( empty( $result ) ) {
         echo "type word!";
      }
      $result = mb_convert_kana( $result, 's' );#全角スペースを半角に変換
      $key = explode( ' ', $result );#検索に入力された内容(resultからもってきた
      $key_ctr = 0;#カウンタ変数
      $key_ctr = count( $key );

   $sql = "SELECT * FROM hatugen INNER JOIN people_info ON hatugen.id_people_info = people_info.id_people_info";
   $stmt = $dbh->query($sql);
   foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
      $name = print_r($test_auto['name'], TRUE);
      $detail = print_r($test_auto['detail'], TRUE);

      $int_ctr = 0;#カウンタ変数

      $integrated = $name.$detail;

      foreach( $key as $val ){#$keyの複数入っている要素を一つずつ$valに入れてループを回す
         $pos = strpos( $integrated, $val );#$integratedと$valの内容を比較
         if( $pos !== false ){
            $int_ctr += 1;
         };
      }

      if( $key_ctr === $int_ctr ){
            print_r($name);
            echo "<br>";
            print_r($detail);
            echo "<br>";
      }else{
         continue;
      }

   }
      $dbh = null;
   }

   top();

$file_name = $_SERVER["SCRIPT_NAME"];
$file_name = str_replace( '/lp/', '', $file_name );
#echo $file_name;

if( $file_name === 'member.html' ){
   member();
}else if( $file_name === 'bill.html' ){
   bill();
}else if( $file_name === 'potal site.html' ){
   top();
}

      

?>
