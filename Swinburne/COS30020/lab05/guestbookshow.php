<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Lab 05 Task 2 - Guestbook</title>
</head>

<body>

    <h1>Lab 05 Task 2 - Guestbook</h1>

    <?php
    $filename = "../../data/lab05/guestbook.txt"; // assumes php file is inside lab05

    // if (is_readable($filename)) {
    //     echo "<pre>";
    //     readfile($filename);
    //     echo "</pre>";
    // } else {
    //     echo "<p>Guestbook file is not readable.</p>";
    // }

    if (is_readable($filename)) {
        $content = file_get_contents($filename);

        if ($content !== false) {
            $entries = explode("\n", $content);

            echo "<pre>";
            foreach ($entries as $entry) {
                $entry = stripslashes($entry);
                echo $entry . "\n";
            }
            echo "</pre>";
        } else {
            echo "<p>Unable to read guestbook file content.</p>";
        }
    } else {
        echo "<p>Guestbook file is not readable.</p>";
    }
    ?>

</body>

</html>