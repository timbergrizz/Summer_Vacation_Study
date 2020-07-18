<?php
    require_once("../lib/default.php");
    $filtered = filterSQL($_POST, $conn);

    $sql = query(3, 1, $filtered).where("user", $_SESSION["user_id"]);
    $res = mysqli_query($conn, $sql);

    sqlFailureCheck($res);
    messageScriptExe("savesuc", "index", 1);
?>