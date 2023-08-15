<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Lab 4 - Task 3</title>
</head>
<body>
    <h1>Lab 04 Task 3 - Standard Palindrome</h1>
    <?php
    if (isset ($_POST["myString"])) { // check if form data exists

        $str = $_POST["myString"]; // obtain the form data
        
        $lower_str = strtolower($str); // convert to lower case

        $replaced_str = str_replace([' ', '.', ',', '!', '?', ';', ':', '-', '_', '"', "'", '(', ')'], '', $lower_str);
        
        $reversed_str = strrev($replaced_str); // reverse the string

        if (strcmp($replaced_str, $reversed_str) == 0) { // check if the string is a palindrome
            
            echo "<p>The text you entered: '", $str, "' is a standard palindrome!</p>";

        } else { // string is not a palindrome
            echo "<p>The text you entered: '", $str, "' is not a standard palindrome.</p>";
        }
    } else { // no input
        echo "<p>Please enter string from the input form.</p>";
    }
    ?>
</body>
</html>
