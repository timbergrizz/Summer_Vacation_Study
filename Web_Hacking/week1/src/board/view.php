<?php
require_once("lib/default.php");
$filtered = filterSQL($_GET, $conn);

// article view
$type = tableType(2);
$par = array("*" => "");
$sql = query(2, 2, $par).joinTable(2, 1, "user").where($type, $filtered[$type."_id"]);

$result = query_return_arr($conn, $sql);
$result = filterXSS($result);

// comment view
$button = accessButton($_SESSION["user_id"], $result["user_id"], 2, $result["article_id"]);
$sql = query(2, 3, $par).joinTable(3, 1, "user").where($type, $filtered[$type."_id"]);

$resultComment = mysqli_query($conn, $sql);
$button = accessButton($_SESSION["user_id"], $result["user_id"], 2, $result["article_id"]);

$arg = array(
    "comment_id" => "Comment ID", "comment" => "Comment", "user_id" => "User ID", "created_date" => "Date"
);

$tableScript = tableBuild($arg, $resultComment, $_SESSION["user_id"]);
if(isset($_SESSION["user_id"])){
    $commentScript =
    '<form action="proc/create.php?type=3" method="POST">
    <input type="hidden" name="article_id" value="'.$result["article_id"].'">
    <p><textarea name="comment" placeholder="comment"></textarea></p>
    <p><input type="submit"></p>
    </form>
    ';
}
?>


<html>
  <head>
    <meta charset="utf-8">
    <title>WELCOME</title>
  </head>
  <body>
    <h2><?=$result['title'] ?></h2>
    
    
    <p>
        Writer : <?=$result['nickname']?>(<?=$result['user_id'] ?>)<br>
        Created : <?=$result['created'] ?>
    </p>
    <p>
        <?=$result['content'] ?>
    </p>
    
    <?=$button?>
    <p><a href="index.php">Return Home</a></p>
    <p><a href="board.php">Back To List</a></p>
    <?php
    
    ?>
    <h4>Comments  </h4>
    <?=$commentScript?>
    <table>
        <?=$tableScript ?>
    </table>
    </body>
</html>