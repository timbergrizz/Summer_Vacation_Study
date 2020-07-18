<?php
require_once("lib/default.php");
loginCheckNoProc($_SESSION["user_id"]);
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>User Information</title>
  </head>
  <body>
    <h1>User Information</h1>
        <form action="proc/password.php" method="post">
            <p>Old Password : <input type="password" name="passwordF"></p>
            <p>New Password : <input type="password" name="password"></p>
            <p>Password Confirm : <input type="password" name="passwordC"></p>
            <p><input type="submit"></p>
        </form>
    <p><a href="index.php">Go to Mainpage</a></p>
  </body>
</html>