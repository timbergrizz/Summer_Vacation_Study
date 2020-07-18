<?php
require_once("lib/default.php");
$filtered = filterSQL($_GET, $conn);
accessDeny($filtered["user_id"], $_SESSION["user_id"]);

$argList = array("*" => " ");
$sql = query(2, 1, $argList).where("user", $filtered["user_id"]);
$result = query_return_arr($conn, $sql);

$filtered = filterXSS($result);
?>
<script>
function buttonClick(){
    window.location.href = "../password.php";
}
</script>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>User Information</title>
  </head>
  <body>
    <h1>User Information</h1>

    <p>User ID : <?=$filtered["user_id"]?></p>
    <form action="../proc/user.php" method="post">
        <p>Nickname : <input type="text" name="nickname" value="<?=$filtered["nickname"]?>"></p>
        <p>Profile : <textarea name="profile"><?=$filtered["profile"]?></textarea></p>
        <p><input type="submit" value="Edit"><p>
    </form>
    <a><button onclick="buttonClick()">Change Password</button></a>
  </body>
</html>