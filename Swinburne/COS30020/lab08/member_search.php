<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Member Page</title>
</head>

<body>
    <h1>Search Members</h1>
    <form method="post" action="member_search.php">
        <label for="last_name">Enter Last Name:</label>
        <input type="text" id="last_name" name="last_name">
        <input type="submit" value="Search">
    </form>

    <?php
    if (
        $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST["last_name"])
    ) {

        require_once("settings.php");

        // Connect to mysql server
        $conn = @mysqli_connect($host, $user, $pswd) or die('Failed to connect to server');
        // Use database
        @mysqli_select_db($conn, $dbnm) or die('Database not available');


        // Retrieve the last name from the form
        $searchLastName = mysqli_escape_string($conn, $_POST["last_name"]);

        // Prepare and execute the SQL query to search for members
        
        // // Contains
        // $searchQuery = "SELECT member_id, fname, lname, email FROM vipmembers WHERE lname LIKE '%$searchLastName%'";
        
        // Exact match
        $searchQuery = "SELECT member_id, fname, lname, email FROM vipmembers WHERE lname = '$searchLastName'";
        
        $results = $conn->query($searchQuery);

        if ($results->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table width='100%' border='1'>";
            echo "<tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                </tr>";

            $row = mysqli_fetch_row($results);
            while ($row) {
                echo "<tr>
                <td>{$row[0]}</td>
                <td>{$row[1]}</td>
                <td>{$row[2]}</td>
                <td>{$row[3]}</td>
                </tr>";
                $row = mysqli_fetch_row($results);
            }

            echo "</table>";
        } else {
            echo "No matching members found.";
        }
        // ## 3. close the connection
        mysqli_free_result($results);
        mysqli_close($conn);
    }
    ?>
</body>

</html>