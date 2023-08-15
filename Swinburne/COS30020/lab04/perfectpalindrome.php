<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Lab 4 - Task 2</title>
</head>
<body>
    <h1>Lab 04 Task 2 - Perfect Palindrome</h1>
    <?php
    if (isset ($_POST["myString"])) { // check if form data exists

        $str = $_POST["myString"]; // obtain the form data
        
        $lower_str = strtolower($str); // convert to lower case
        
        $reversed_str = strrev($lower_str); // reverse the string

        if (strcmp($lower_str, $reversed_str) == 0) { // check if the string is a palindrome
            
            echo "<p>The text you entered: '", $str, "' is a perfect palindrome!</p>";

        } else { // string is not a palindrome
            echo "<p>The text you entered: '", $str, "' is not a perfect palindrome.</p>";
        }
    } else { // no input
        echo "<p>Please enter string from the input form.</p>";
    }
    ?>
</body>
</html>
