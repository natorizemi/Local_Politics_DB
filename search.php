<?php
   
   /////db処理/////
   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web', 'root', 'gai0730');
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

   //処理

   $result = $_POST['search'];

   if( empty( $result ) ) {
      echo "type word!";
   }

   $sql = "SELECT * FROM hatugen INNER JOIN people_info ON hatugen.id_people_info = people_info.id_people_info";
   $stmt = $dbh->query($sql);
   foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
      $name = print_r($test_auto['name'], TRUE);
      $detail = print_r($test_auto['detail'], TRUE);

      if(( strpos($detail, $result)) !== false ){
         echo "<br>";
         print_r($name);
         echo "<br>";
         print_r($detail);
         echo "<br>";
      }else{
         continue;
      }
   }
      $dbh = null;
      

?>
