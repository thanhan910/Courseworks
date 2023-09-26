<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Count visits</title>
</head>

<body>
    <h1>Hit counter</h1>

    <?php
    require_once("hitcounter.php");
    require_once("mykeys.inc.php"); // Include your connection details file

    $Counter = new HitCounter($host, $user, $pswd, $dbnm, "hitcounter");
    $Counter->setHits();
    $hits = $Counter->getHits();
    $Counter->closeConnection();

    echo "This page has received " . $hits . " hits.";
    ?>
    <footer>
        <a href="startover.php">Start over</a>
    </footer>


</body>

</html>