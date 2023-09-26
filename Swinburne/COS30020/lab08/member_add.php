<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Member Add</title>
</head>

<body>

    <h1>Web Programming - Lab08</h1>
    <h2>Member Add</h2>


    <?php
    require_once("settings.php");

    // Connect to mysql server
    $conn = @mysqli_connect($host, $user, $pswd) or die('Failed to connect to server');
    // Use database
    @mysqli_select_db($conn, $dbnm) or die('Database not available');

    // Create the 'vipmembers' table if it doesn't exist
    $tableCreationQuery = "CREATE TABLE IF NOT EXISTS vipmembers (
        member_id INT AUTO_INCREMENT PRIMARY KEY,
        fname VARCHAR(40) NOT NULL,
        lname VARCHAR(40) NOT NULL,
        gender VARCHAR(1) NOT NULL,
        email VARCHAR(40) NOT NULL,
        phone VARCHAR(20) NOT NULL
    )";

    if ($conn->query($tableCreationQuery) === TRUE) {
        echo "Table 'vipmembers' created or already exists.<br>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Collect data from the "Add New Member Form"
    if (
        $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST['fname'])
        && isset($_POST['lname'])
        && isset($_POST['gender'])
        && isset($_POST['email'])
        && isset($_POST['phone'])
    ) {

        // get data from user, escape it, trust no-one. :)
        $fname = mysqli_escape_string($conn, $_POST['fname']);
        $lname = mysqli_escape_string($conn, $_POST['lname']);
        $gender = mysqli_escape_string($conn, $_POST['gender']);
        $email = mysqli_escape_string($conn, $_POST['email']);
        $phone = mysqli_escape_string($conn, $_POST['phone']);

        // Insert the data into the 'vipmembers' table
        $insertQuery = "INSERT INTO vipmembers (fname, lname, gender, email, phone) VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";
        $results = mysqli_query($conn, $insertQuery);

        if ($results) {
            echo "New member added successfully.<br />" . $fname . '<br />' . $lname . '<br />' . $gender . '<br />' . $email . '<br />' . $phone;
        } else {
            echo "Error inserting member: " . $stmt->error;
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

</body>

</html>