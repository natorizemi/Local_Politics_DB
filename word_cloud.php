
<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>D3 Word Clouds</title>
    <meta name="author" content="d4i"/>
  </head>
  <body>
  
    <?php

   error_reporting(E_ALL & ~E_NOTICE);//NOTICEエラーを非表示にする

   /////db処理/////
   try{
      $dbh = new PDO('mysql:host=localhost;dbname=natori_web', 'root', 'gai0730');
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }catch(PDOException $e){
      var_dump($e->getMessage());
      exit;
   }

   //処理

   $search = $_POST['search'];

   $sql = "SELECT * FROM hatugen INNER JOIN people_info ON hatugen.id_people_info = people_info.id_people_info";
   $stmt = $dbh->query($sql);
   foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $test_auto ){
      $name = print_r($test_auto['name'], TRUE);
      $detail = print_r($test_auto['detail'], TRUE);

      if( strpos( $name, $search ) !==false ){
         $text .= $detail;

         #print_r($text);
         #echo "<br>";

      //切断
      $dbh = null;
     }
   }


  
      $exe_path = '/usr/local/bin/mecab';

      /////pipe処理/////
      $descriptorspec = array(
         0 => array("pipe", "r"),
         1 => array("pipe", "w")
      );

      /////file処理/////
      $process = proc_open($exe_path, $descriptorspec, $pipes);
   
      if (is_resource($process)) {
         fwrite($pipes[0], $text);
         fclose($pipes[0]);  
         while(!feof($pipes[1])){
         $result[] = fgets($pipes[1]);
         }
         fclose($pipes[1]);
         proc_close($process);
      }

   $text = mb_convert_kana( $text, s );
   $text = trim($text, " ");

   print_r($text);
   echo "<br>";

   /////count処理/////
   exec("$exe_path $text", $result);
   $word_list_index = $word_list = $tmp_detail = $tmp = array();
foreach ($result as $val) {
  $tmp = explode(",", $val);

  #print_r($tmp);
  #echo "<br>";

  if ($tmp[1] === '非自立' || $tmp[1] === '代名詞' || $tmp[1] === '副詞可能') {
     continue;
  }

  #print_r($tmp);
  #echo"<pre>";

  /*
  $negative_type_index = array("非自立", "代名詞", "副詞可能");
  foreach( $negative_type_list_index as $negative_type_list ){
     if ($tmp[1] === $negative_type_list) {
        continue;
     }
  }*/

     $tmp_detail = $tmp[1];
     $tmp = explode("\t", $tmp[0]);// $tmp[0]: 要素, $tmp[1]: 品詞
     $tmp[2] = $tmp_detail;

        if( $tmp[0] == NULL || $tmp[2] == '  名詞' ){
           $tmp[0] = ',';
           $tmp[1] = 'test';
           $tmp[2] = '名詞';
        }
        if( $tmp[2] == '数' ){
           $tmp[0] = mb_convert_kana( $tmp[0], "KVa" );
        }



        #print_r($tmp);
        #echo "<pre>";

  if( $tmp[1] == '名詞' || $tmp[2] == '数接続' || $tmp[2] == '名詞接続' || $tmp[2] == '名詞' || $tmp[0] == '・' ) {
     $integrated_word .= $tmp[0];
  #}else if( $tmp[1] == '動詞' ){
   #  $integrated_word .= $tmp[0];
    # unset( $integrated_word );
  }else{
     $negative_word_list_index = array("議員", "問目", "点目", "質問", "お願い", "お答え", "お尋ね", "ご答弁", "平成", "お考え", "ご説明", "ページ", "ご指摘");
     foreach( $negative_word_list_index as $negative_word_list){
        if( strpos( $integrated_word, $negative_word_list ) !== false ){
           $integrated_word = NULL;
        }
     }
     if( $integrated_word === "," ){
        $integrated_word = NULL;
     }
     $key = array_search($integrated_word, $word_list_index);
     if ($key === false) {// 新出
        $word_list[] = array('num' => 1, 'word' => $integrated_word);
        $word_list_index[] = $integrated_word;
      } else {// 既出
        $word_list[$key]['num'] = $word_list[$key]['num'] + 1;
      }
     $integrated_word = NULL;
  }
}
unset( $word_list[0] );
#print_r($word_list);

   unset($word_list_index);
   
   arsort($word_list);
   $num = current( $word_list );
   #$num = print_r($first['num']);

   $test[] = array("count","word");
   
   foreach ($word_list as $val) {
    $test[] = array("{$val['num']}", "{$val['word']}");
   }
   

echo '<table ncurses_border(left, right, top, bottom, tl_corner, tr_corner, bl_corner, br_corner)r="1" cellpadding="5">';
foreach ($word_list as $val) {
  echo "<tr><td>{$val['num']}</td><td>{$val['word']}</td></tr>\n";
}
echo "</table>";

   $fp = fopen('text.csv', 'w');
   
   foreach($test as $fields){
     print_r($fields, TRUE);
   fputcsv($fp, $fields);
   }
   
   fclose($fp);
   ?>
  
    <script type="text/javascript" src="js/d3.js"></script>
    <script type="text/javascript" src="js/wc.js"></script>

    <script>
      var file = 'text.csv';

      d3.csv(file, function(data){
        var data = data.splice(0, 250);

        var max_num = <?php print_r( $num['num'] ); ?>;

        //要変更
        if( max_num <= 10 ){
           var num = 100;
        }else if( max_num <= 20 ){
           var num = 10;
        }else if( max_num <= 30 ){
           var num = 5;
        }else{
           var num = 1;
        };

        var width = window.innerWidth;
        var height = window.innerHeight;
        var fill = d3.scale.category20();
        var maxcount = d3.max(data, function(d){ return d.count; } );
        var wordcount = data.map(function(d) { return {text: d.word, size: d.count / maxcount * 10}; });

        d3.layout.cloud().size([width, height])
        .words(wordcount)
        .padding(5)
        .rotate(function() { return ~~(Math.random() * 2) * 90; })
        .font("Impact")
        .fontSize(function(d) { return Math.sqrt(d.size) * num; })
        .on("end", draw)
        .start();

          function draw(words) {
            d3.select("body").append("svg")
              .attr({
                 "height": height,
                 "width": width,
              })
              .append("g")
              .attr("transform", "translate(" + [ width >> 1, height >> 1 ] + ")")
              .selectAll("text")
              .data(words)
              .enter()
              .append("text")
              .style({
                 "font-size": function(d) { return d.size + "px"; },
                 "font-family": "Impact",
                 "fill": function(d, i) { return fill(i); }
              })
              .attr({
                 "text-anchor": "middle",
                 "transform": function(d) { return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")"; }
              })
          .text(function(d) { return d.text; })
          .on("mouseover", function(d){
             d3.select(this).style({opacity: '0.6'});
          })
          .on("mouseout", function(d){
             d3.select(this).style({opacity: '1.0'});
          })
        };
      });
    </script>
  
  </body>
</html>