<?php
session_start(); // start the session
if (isset($_SESSION["number"])) { // check if session variable exists
    unset($_SESSION["number"]); // unset all session variables
}
session_destroy(); // destroy all data associated with the session
header("location:number.php"); // redirect to number.php
?>