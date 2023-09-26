<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Member Display</title>
</head>

<body>

    <h1>Web Programming - Lab08</h1>
    <h2>Member Display</h2>

    <?php
    require_once("settings.php");
    // complete your answer based on Lecture 8 slides 26 and 44

    // ## 1. open the connection
    // Connect to mysql server
    $conn = @mysqli_connect($host, $user, $pswd) or die('Failed to connect to server');
    // Use database
    @mysqli_select_db($conn, $dbnm) or die('Database not available');

    // ## 2. set up SQL string and execute 
    // // get data from user, escape it, trust no-one. :)
    // $pcode = mysqli_escape_string($conn, $_GET['pcode']);

    $query = "SELECT member_id, fname, lname FROM vipmembers";
    $results = mysqli_query($conn, $query);

    // … Now use data however we want …

    echo "<table width='100%' border='1'>";
    echo "<tr><th>Member ID</th><th>First name</th><th>Last name</th></tr>";
    $row = mysqli_fetch_row($results);
    while ($row) {
        echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td></tr>";
        $row = mysqli_fetch_row($results);
    }
    echo "</table>";

    // ## 3. close the connection
    mysqli_free_result($results);
    mysqli_close($conn);
    ?>

</body>

</html>