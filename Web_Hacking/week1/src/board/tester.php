<?php
    require_once("lib/default.php");
 
    $type = tableType(2);
$par = array("*" => "");
$sql = query(2, 2, $par)."left join user on article.user_id = user.user_id ".where($type, $filtered[$type."_id"]);

echo $sql;
?>

<table style="width:100%">
<?=$tableScript?>
</table>