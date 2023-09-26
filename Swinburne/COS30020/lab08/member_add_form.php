<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh An Nguyen" />
    <title>Member add</title>
</head>

<body>
    <h1>Web Programming - Lab08</h1>
    <h2>Add New Member Form</h2>
    <form action="member_add.php" method="post">
        <label for="fname">First name: </label>
        <input type="text" name="fname" maxlength="40" />
        <br />
        <label for="lname">Last name: </label>
        <input type="text" name="lname" maxlength="40" />
        <br />
        <label for="gender">Gender: </label>
        <input type="text" name="gender" maxlength="1" />
        <br />
        <label for="email">Email: </label>
        <input type="text" name="email" maxlength="40" />
        <br />
        <label for="phone">Phone: </label>
        <input type="text" name="phone" maxlength="20" />
        <br />
        <input type="submit" value="Submit" />
    </form>

</body>

</html>