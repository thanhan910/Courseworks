<?php
session_start(); // start the session
if (!isset($_SESSION["number"])) { // check if session variable exists
    $_SESSION["number"] = 0; // create the session variable
}
$num = $_SESSION["number"]; // copy the value to a variable
$num--; // decrement the value
$_SESSION["number"] = $num; // update the session variable
header("location:number.php"); // redirect to number.php
?>