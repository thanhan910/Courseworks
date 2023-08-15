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
    <h1>Lab 06 Task 2 - Guestbook</h1>
    <form action="guestbooksave.php" method="post">
        <fieldset>
            <legend>Enter your details to sign our guest book</legend>
            <label for="myName">Name </label>
            <input type="text" name="myName" />
            <br />
            <br />
            <label for="myEmail">Email </label>
            <input type="text" name="myEmail" />
            <br />
            <br />
            <input type="submit" value="Sign" /> 
            <input type="reset" value="Reset" />
        </fieldset>
    </form>
    <a href=" guestbookshow.php">Show Guest Book</a>
</body>

</html>