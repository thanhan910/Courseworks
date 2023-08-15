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
    <?php // read the comments for hints on how to answer each item
    if (isset($_POST["first_name"]) && isset($_POST["last_name"])) { // check if both form data exists
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        if (!empty($first_name) && !empty($last_name)) {
            umask(0007);
            $dir = "../../data/lab05";
            if (!file_exists($dir)) {
                mkdir($dir, 02770);
            }

            $filename = "../../data/lab05/guestbook.txt"; // assumes php file is inside lab05

            $handle = fopen($filename, "a"); // open the file in append mode

            if ($handle) {
                $first_name = addslashes($first_name);
                $last_name = addslashes($last_name);

                $data = $last_name . ", " . $first_name . "\n";

                $bytesWritten = fwrite($handle, $data);

                if ($bytesWritten !== false) {

                    fclose($handle);

                    echo "<p>Thank you for signing our guest book!</p>";
                } else {
                    echo "<p>Cannot add your name to the Guest book.</p>";
                }
            } else {
                echo "Cannot open the guestbook file for writing.";
            }
        } else {
            echo "<p>You must enter your first and last name!</p>";
            echo "<p>Use the Browser's Go Back button to return to the Guestbook form.</p>";
        }
    } else { // no input
        echo "<p>Please enter your first name and last name in the input form.</p>";
    }
    ?>
    <a href=" guestbookshow.php">Show Guest Book</a>
</body>

</html>