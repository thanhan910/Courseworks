<?php
session_start();
if (isset($_SESSION['randNum'])) {
    unset($_SESSION['randNum']);
}
if (isset($_SESSION['guess_count'])) {
    unset($_SESSION['guess_count']);
}
session_destroy();
header("location:guessinggame.php");
?>
