<?php
    require_once("lib/default.php");

    $arg = array("nickname" => "Nickname", "point" => "Point");
    $sql = query(2, 1, $arg)."order by point desc";
    
    $result = mysqli_query($conn, $sql);
    $tableScript = tableBuild($arg, $result);
?>

<table>
    <?=$tableScript?>
</table>