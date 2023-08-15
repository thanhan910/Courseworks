<?php

echo "<p>";

if (isset($_GET["variable"])) { // check if form data exists
    $a = $_GET["variable"];
} else { // no input
    $a = 4;
}


if (is_numeric($a)) {
    echo "The variable ", $a, " <strong>contains an ", (round($a) % 2 == 0) ? "even" : "odd", "<strong> number.";
} else {
    echo "The variable ", $a, " does not contain a number.";
}

echo "</p>";
