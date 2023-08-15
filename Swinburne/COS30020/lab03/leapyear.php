<!DOCTYPE html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <title>Using if and while statements</title>
</head>

<body>
    <?php
    function is_leapyear($year) {
        if($year % 4 == 0) {
            if($year % 100 == 0) {
                if($year % 400 == 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
     ?>
    <h1>Lab03 Task 2 - Leap Year</h1>
    <?php
    if (isset($_GET["myyear"])) { // check if form data exists
        $year = $_GET["myyear"]; // obtain the form data
        if (is_numeric($year) && $year > 0) { // check if $year is a positive number
            if ($year == round($year)) { // check if $year is an integer
                echo "<p>The year you entered ", $year, " is a ", is_leapyear($year) ? "leap" : "standard" , " year.</p>";
            } else { // number is not an integer
                echo "<p>Please enter an integer.</p>";
            }
        } else { // number is not positive
            echo "<p>Please enter a positive integer. </p>";
        }
    } else { // no input
        echo "<p>Please enter a positive integer.</p>";
    }
    ?>
</body>

</html>