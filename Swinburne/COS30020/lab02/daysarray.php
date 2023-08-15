<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Programming :: Lab 2" />
    <meta name="keywords" content="Web,programming" />
    <title>Days of the week</title>
</head>

<body>
    <?php
    $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    echo "<p>The Days of the week in English are: <br />";
    for ($i = 0; $i < count($days); $i++) {
        echo $days[$i];
        if ($i < count($days) - 1) echo ", ";
    }
    echo "</p>";

    $days[0] = "Dimanche";
    $days[1] = "Lundi";
    $days[2] = "Mardi";
    $days[3] = "Mercredi";
    $days[4] = "Jeudi";
    $days[5] = "Vendredi";
    $days[6] = "Samedi";

    echo "<p>The Days of the week in French are: <br />";
    for ($i = 0; $i < count($days); $i++) {
        echo $days[$i];
        if ($i < count($days) - 1) echo ", ";
    }
    echo "</p>";
    ?>
</body>

</html>