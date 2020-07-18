<?php
require_once("lib/default.php");
loginCheckNoProc($_SESSION['user_id']);
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create New Article</title>
  </head>
  <body>
    <h1>Create New Article</h1>
    <form action="proc/create.php?type=2" method="POST"  enctype="multipart/form-data">
        <p><input type="text" name="title" placeholder="title"></p>
        <p><textarea name="content" placeholder="content"></textarea></p>
        <p><input type="submit"></p>
    </form>
  </body>
</html>