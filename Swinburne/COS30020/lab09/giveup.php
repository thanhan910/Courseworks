<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Up</title>
</head>
<body>
    <h1>Guessing Game</h1>
    
    <?php
    session_start();

    if (isset($_SESSION['randNum'])) {
        echo "<p>The hidden number was: {$_SESSION['randNum']}</p>";
        unset($_SESSION['randNum']);
        unset($_SESSION['guess_count']);
    } else {
        echo "<p>No active game to give up on.</p>";
    }
    ?>

    <a href="guessinggame.php">Start Over</a>
</body>
</html>
