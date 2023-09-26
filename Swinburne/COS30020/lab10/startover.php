<?php
require_once("hitcounter.php");
require_once("mykeys.inc.php"); // Include your connection details file

$Counter = new HitCounter($host, $user, $pswd, $dbnm, "hitcounter");
$Counter->startOver();
$Counter->closeConnection();
echo "Hit counter reset.";
echo "<a href='countvisits.php'>Count visits</a>"
?>
