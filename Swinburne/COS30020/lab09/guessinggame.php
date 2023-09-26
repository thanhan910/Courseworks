<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game</title>
</head>

<body>
    <h1>Guessing Game</h1>

    <p>Enter a number between 1 and 100, then press the Guess button</p>
    <form method="POST" action="guessinggame.php">
        <input type="text" name="guess">
        <input type="submit" value="Guess">
    </form>

    <?php
    // Initialize session variables
    session_start();

    // Generate a random number if it doesn't exist in the session
    if (!isset($_SESSION['randNum'])) {
        $_SESSION['randNum'] = rand(1, 100); // Change the range as needed
    }

    // Initialize the guess count if it doesn't exist in the session
    if (!isset($_SESSION['guess_count'])) {
        $_SESSION['guess_count'] = 0;
    }

    // Check if the user has submitted a guess
    if (isset($_POST['guess'])) {
        $userGuess = intval($_POST['guess']);
        $_SESSION['guess_count']++;

        if (is_numeric($userGuess) && $userGuess >= 1 && $userGuess <= 100) {
            if ($userGuess == $_SESSION['randNum']) {
                echo "<p>Congratulations! You guessed the correct number {$_SESSION['randNum']} in {$_SESSION['guess_count']} guesses.</p>";
            } elseif ($userGuess < $_SESSION['randNum']) {
                echo "<p>Your guess ($userGuess) is too low.</p>";
            } else {
                echo "<p>Your guess ($userGuess) is too high.</p>";
            }
        } else {
            echo "<p>Please enter a valid numeric guess between 1 and 100.</p>";
        }
    }
    ?>

    <?php
    if (isset($_SESSION['guess_count'])) {
        echo "<p>Number of guesses: {$_SESSION['guess_count']}</p>";
    }
    ?>
    <p><a href="giveup.php">Give Up</a></p>
    <p><a href="startover.php">Start Over</a></p>
</body>

</html>