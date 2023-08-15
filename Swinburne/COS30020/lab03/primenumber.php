<!DOCTYPE html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <title>Using if and while statements</title>
</head>

<body>
    <?php
    function is_prime($num) {
        $i = 2;
        while ($i < $num) {
            if ($num % $i == 0) {
                return false;
            }
            $i++;
        }
        return true;
    }
     ?>
    <h1>Lab03 Task 2 - Leap Year</h1>
    <?php
    if (isset($_GET["mynum"])) { // check if form data exists
        $num = $_GET["mynum"]; // obtain the form data
        if (is_numeric($num) && $num > 0) { // check if $num is a positive number
            if ($num == round($num)) { // check if $num is an integer
                echo "<p>The number you entered ", $num, " is ", is_prime($num) ? "" : "not" , " a prime number.</p>";
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