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
   
    <h2>Sign Guestbook</h2>

    <?php // read the comments for hints on how to answer each item
    if (isset($_POST["myName"]) && isset($_POST["myEmail"])) { // check if both form data exists
        $name = $_POST["myName"];
        $email = $_POST["myEmail"];

        if (!empty($name) && !empty($email)) {

            if (preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $email)) {
                echo "<p>Email address is valid.</p>";
            } else {
                echo "<p>Email address is not valid.</p>";
                exit;
            }               
            
            $name = addslashes($name);
            $email = addslashes($email);

            umask(0007);
            $dir = "../../data/lab06";
            if (!file_exists($dir)) {
                mkdir($dir, 02770);
            }

            $filename = "../../data/lab06/guestbook.txt"; // assumes php file is inside lab05

            if (file_exists($filename)) { // check if file exists for reading
                
                // Create empty arrays
                $namedata = array(); 
                $emaildata = array();
                
                $handle = fopen($filename, "r"); // open the file in read mode

                while (!feof($handle)) { // loop while not end of file

                    $onedata = fgets($handle); // read a line from the text file
                    
                    if ($onedata != "") { // ignore blank lines

                        $data = explode(" \t ", $onedata); // explode string to array
                    
                        $namedata[] = $data[0]; // create a string element
                        $emaildata[] = $data[1]; // create a string element
                    }
                }

                fclose($handle); // close the text file

                $newdata = !(in_array($name, $namedata) || in_array($email, $emaildata)); // check if name exists in array

            } else {
                $newdata = true; // file does not exists, thus it must be a new data
            }

            if ($newdata) {

                $handle = fopen($filename, "a"); // open the file in append mode
    
                if ($handle) {

                    $data = $name . " \t " . $email . "\n";

                    $bytesWritten = fputs($handle, $data);

                    if ($bytesWritten !== false) {

                        fclose($handle);

                        echo "<p>Thank you for signing our guest book:</p>"
                        ."<p><strong>Name: </strong>" . stripslashes($name) . "</p>"
                        ."<p><strong>Email: </strong>" . stripslashes($email) . "</p>";

                    } 
                    
                    else {
                        echo "<p>Cannot add your name to the Guest book.</p>";
                    }

                } 
                
                else {
                    echo "<p>Cannot open the guestbook file for writing.</p>";
                }

            } 
            
            else {
                echo "<p>You have already signed the guest book!</p>";
            }
            
        } else {
            echo "<p>You must enter your name and email address!</p>";
            echo "<p>Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
        }
    } else { // no input
        echo "<p>Please enter your first name and last name in the input form.</p>";
    }
    ?>
    <p><a href=" guestbookform.php">Add Another Visitor</a></p>
    <p><a href=" guestbookshow.php">Show Guest Book</a></p>
</body>

</html>