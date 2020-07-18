<?php
require_once("lib/default.php");
if(isset($_SESSION['user_id']))
  messageScriptExe("alreadylogged", "index", 0);
?>
<!doctype html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <h1>Login</h1>

    <?=$login_fallure ?>
    <form action="proc/login.php" method="post">
        <p><input type="text" name="user_id" placeholder="ID"></p>
        <p><input type="password" name="password" placeholder="Password"></p>
        <p><input type="submit" value="Login"><p>
    </form>
    <a href="register.php">Sign Up</a>
  </body>
</html>