<?php
require_once("lib/default.php");

$filterGet = filterSQL($_GET, $conn);
authentication($_SESSION["user_id"], $filterGet["id"], $conn, $filterGet["type"]);

if($filterGet["type"] == "article") $typeNum = 2;
else $typeNum = 3;

$par = array("*" => "");
$sql = query(2, $typeNum, $par).where($filterGet["type"], $filterGet["id"]);

$result = query_return_arr($conn, $sql);
$result = filterXSS($result);

if(isset($result["content"])) $article = $result["content"];
else $article = $result["comment"];

$title = "";
if($filterGet["type"] == "article")
    $title = "<p><input type='text' name='title' value='".$result['title']."'></p>";

$script = "<form action='proc/update.php' method='POST'>"
        .$title.
        "<input type='hidden' name='".$filterGet["type"]."_id' value='".$filterGet["id"]."'>
        <input type='hidden' name='article_id' value='".$result["article_id"]."'>
        <p><textarea name='".$filterGet["type"]."'>".$article."</textarea></p>
        <p><input type='submit'></p>
        </form>
    ";
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Edit <?=$filterGet["type"]?></title>
  </head>
  <body>
    <h1>Edit <?=$filterGet["type"]?></h1>
    <?=$script?>
  </body>
</html>