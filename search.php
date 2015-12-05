<?php
   


   //処理

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
      $result = mb_convert_kana( $result, 's' );
      $key = explode( ' ', $result );
      $key_ctr = 0;
      $key_ctr = count( $key );


         /*$test = $etc = array();

         foreach( $key as $val ){
         $text = "関西大学、田村集中集中";
         print_r($val);
         $pos = strpos( $text, $val );
         if( $pos !== false ){
            $ctr += 1;
         };
         array_push( $test, $val );
         echo "<br>";
         $counter = count($test);
         }
         print_r($test);
         echo "<br>";
         echo $counter;
         echo "<br>";
         echo $ctr;*/

   $sql = "SELECT * FROM hatugen INNER JOIN people_info ON hatugen.id_people_info = people_info.id_people_info";
   $stmt = $dbh->query($sql);
   foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
      $name = print_r($test_auto['name'], TRUE);
      $detail = print_r($test_auto['detail'], TRUE);

      $int_ctr = 0;

      $integrated = $name.$detail;

      foreach( $key as $val ){
         $pos = strpos( $integrated, $val );
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