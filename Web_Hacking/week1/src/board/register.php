<!doctype html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
  </head>
  <body>
    <h1>Register</h1>

    <?=$login_fallure ?>
    <form action="proc/register.php" method="post">
        <p><input type="text" name="user_id" placeholder="ID"></p>
        <p><input type="password" name="password" placeholder="Password"></p>
        <p><input type="text" name="nickname" placeholder="Nickname"></p>
        <p><textarea name="profile" placeholder="Profile"></textarea></p>
        <p><input type="submit" value="Register"><p>
    </form>
    <a href="login.php">Sign Up</a>
  </body>
</html>