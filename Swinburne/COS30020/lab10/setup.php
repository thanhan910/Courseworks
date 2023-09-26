<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Setup</title>
</head>

<body>
    <h1>Setup</h1>
    <form method="post" action="setup.php">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br />

        <label for="databasename">Database Name:</label>
        <input type="text" id="databasename" name="databasename" required>
        <br />

        <input type="submit" value="Set Up">

    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "feenix-mariadb.swin.edu.au";
        $username = $_POST["username"];
        $password = $_POST["password"];
        $database = $_POST["databasename"];

        // Connect to mysql server
        $conn = @mysqli_connect($host, $username, $password) or die('Failed to connect to server');
        // Use database
        $db_conn = @mysqli_select_db($conn, $database) or die('Database not available');

        // Create a data/lab10 directory if it doesn't exist
        umask(0007);
        $dir = "../../data/lab10"; // assumes php file is inside lab10
        if (!file_exists($dir)) {
            mkdir($dir, 02770);
        }

        $filename = $dir . "/mykeys.txt";

        // Store connection details in a text file (mykeys.txt)
        $connectionDetails = "Host: $host\nUsername: $username\nPassword: $password\nDatabase: $database";
        file_put_contents($filename, $connectionDetails);

        $sql = "CREATE TABLE IF NOT EXISTS hitcounter (
                    id SMALLINT NOT NULL PRIMARY KEY,
                    hits SMALLINT NOT NULL
                )";

        if (mysqli_query($conn, $sql)) {
            echo "Table created successfully.<br>";

            // Insert an initial value into the table
            $sql = "INSERT INTO hitcounter (id, hits) VALUES (1, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "Initial value inserted into the table.<br>";
            } else {
                echo "Error inserting initial value: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "Error creating table: " . mysqli_error($conn) . "<br>";
        }


        mysqli_close($conn);
    }
    ?>
</body>

</html>