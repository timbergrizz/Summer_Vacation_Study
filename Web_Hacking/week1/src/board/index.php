<?php
require_once("lib/default.php");

$frontPage = "<p><a href='login.php'>Sign in</a></p>";
if(isset($_SESSION['user_id'])){
    $par = array("user_id" => "id", "nickname"=>"nick");
    $sql = query(2, 1, $par)." where user_id = '{$_SESSION['user_id']}'";

    $user = query_return_arr($conn, $sql);
    $frontPage= "Hello! ".$user['nickname']."
    <p><a href='proc/logout.php'>Sign Out</a></p>
    <p><a href='user.php/?user_id={$_SESSION["user_id"]}'>User Information</a></p>
    "; 
}
?>

<!doctype html>

<html>
  <head>
    <meta charset="utf-8">
    <title>WELCOME</title>
  </head>
  <body>
    <h1>WELCOME</h1>
    <?=$frontPage?>
    <p><a href="board.php">Board</a></p>
    <p><a href="point.php">Point Ranking</a></p>
  </body>
</html>