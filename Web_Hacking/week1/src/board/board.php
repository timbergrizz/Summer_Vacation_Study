<?php
    require_once("lib/default.php");

    $filtered = filterSQL($_GET, $conn);
    $pageNum = 0;
    if(isset($filtered["page"])) $pageNum = ($filtered["page"]-1) * 10;
    $pageEnd = $pageNum + 10;
    
    $return = "";
    if(isset($_SESSION["user_id"])){
        $return = "
            <p><a href='create.php'>Create New Article</a></p>
        ";
    }

   $arg = array("article_id" => "Article ID", "title"=>"Title", "user_id"=>"Writer"); 
   $sql = query(2, 2, $arg)."order by article_id desc limit {$pageNum}, {$pageEnd}";
   $result = mysqli_query($conn, $sql);

   $tableScript = tableBuild($arg, $result);
   $paging = page(2, $conn);
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Board</title>
  </head>
  <body>
    <h1>Board</h1>
    <p><a href="./index.php">Main Page</a></p>
    <?=$return?>
    <table>
      <?=$tableScript ?>
  </table>
    <p>Page : <?=$paging?></p>
  </body>
</html>