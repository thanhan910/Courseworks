<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Lab 06 Task 2 - Guestbook</title>
</head>

<body>

    <h1>Lab 06 Task 2 - Guestbook</h1>

    <h2>View Guestbook</h2>

    <?php
    $filename = "../../data/lab06/guestbook.txt"; // assumes php file is inside lab05

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

            $alldata = array();

            $entries = explode("\n", $content);

            foreach ($entries as $entry) {

                if(empty($entry)) {
                    continue;
                }

                $data = explode(" \t ", $entry);

                array_push($alldata, array($data[0], $data[1]));
            }

            sort($alldata);

            echo "<table>";
            echo "<tr><th>Number</th><th>Name</th><th>Email</th></tr>";

            $index = 1;

            foreach ($alldata as $data) {

                echo "<tr><td>". $index ."</td><td>". stripslashes($data[0]) ."</td><td>". stripslashes($data[1]) ."</td></tr>";

                $index++;

            }
            echo "</table>";

        } else {
            echo "<p>Unable to read guestbook file content.</p>";
        }
    } else {
        echo "<p>Guestbook file is not readable.</p>";
    }
    ?>

</body>

</html>