<?php
// check if session started, then start session
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	// SESSIONs that help block direct url access
	// $_SESSION["in_process_order_php"];
	// $_SESSION["in_payment_php"];
	// $_SESSION["in_fix_order_php"];
	// $_SESSION["in_receipt_php"];
	// block user from directly accessing from url if the user has not submit the form
	if (!isset($_SESSION["in_process_order_php"])) {
		unset($_SESSION["in_process_order_php"]);
		header("location:enquire.php");
	}
	else {
		unset($_SESSION["in_process_order_php"]);
		$_SESSION["in_receipt_php"] = true;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Receipt" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Receipt" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Receipt</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body>
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<!-- Receipt -->
	<section id="receipt_section">
		<h2 class="content_header">Receipt</h2>
		<hr />
		<h3>Order Details</h3>
		<hr />
		<?php
			echo '<p>Order ID: ', $_SESSION["order_id"],'</p>';
			echo '<p>Order time: ', date('Y-m-d', $_SESSION["order_time"]), '</p>';
			echo '<p>Order status: ', $_SESSION["order_status"],'</p>';
			echo '<p>Order cost: $', number_format($_SESSION["order_cost"],0,".",","),'</p>';
		?>
		<hr />
		<h3>Personal Information</h3>
		<hr />
		<!-- <h4>Name</h4> -->
		<?php
			echo '<p>First Name: ', $_SESSION["first_name"],'</p>';
			echo '<p>Last Name: ', $_SESSION["last_name"],'</p>';
		?>
		<h4>Contact Information:</h4>
		<?php
			echo '<p>Email Address: ', $_SESSION["email_address"],'</p>';
			echo '<p>Street Address: ', $_SESSION["street_address"],'</p>';
			echo '<p>Suburb/Town: ', $_SESSION["suburb_town"],'</p>';
			echo '<p>State: ', $_SESSION["state"],'</p>';
			echo '<p>Postcode: ', $_SESSION["postcode"],'</p>';
			echo '<p>Phone Number: ', $_SESSION["phone_number"],'</p>';
			echo '<p>Preferred contact method: ', $_SESSION["preferred_contact"],'</p>';
		?>
		<hr />
		<h3>Laptop Details</h3>
		<hr />
		<h4>Laptop:</h4>
		<?php
			echo '<p>',$_SESSION["choose_product"],'</p>';
		?>
		<h4>Added Features:</h4>
		<?php
			echo '<p>Memory: ', $_SESSION["memory"],'</p>';
			echo '<p>Storage: ', $_SESSION["storage"],'</p>';
			echo '<p>Storage Device: ', $_SESSION["storage_device"],'</p>';
			echo '<p>Operating System: ', $_SESSION["OS"],'</p>';
		?>
		<h4>More information:</h4>
		<?php
			echo '<p>', $_SESSION["write_more"],'</p>';
		?>
		<hr />
		<h3>Payment Details</h3>
		<hr />
		<?php
			echo '<p>Number of laptops: ', number_format($_SESSION["quantity"],0,".",","),'</p>';
			echo '<p>Cost per laptop: $', number_format($_SESSION["cost_per_laptop"],0,".",","),'</p>';
			echo '<p>Total price: <strong>$', number_format($_SESSION["order_cost"],0,".",","),'</strong></p>';
		?>
		<h4>Credit card information:</h4>
		<?php
			echo '<p>Card type: ', $_SESSION["credit_card_type"],'</p>';
			echo '<p>Name on card: ', $_SESSION["credit_card_name"],'</p>';
			// card number should be partly hidden
			$CCN = $_SESSION["credit_card_number"];
			$CCN_length = strlen($CCN);
			echo '<p>Card number: ', (int)substr($CCN, 0, 2), str_repeat("*", $CCN_length - 2),'</p>';
			// expiry date
			echo '<p>Expiry date: ', $_SESSION["credit_card_expiry_date"],'</p>';
			// card verification value should be partly hidden
			$CVV = $_SESSION["credit_card_verification_value"];
			$CVV_length = strlen($CVV);
			echo '<p>Card verification value: ', str_repeat("*", $CVV_length) ,'</p>';
			session_unset(); // unset all session variables
			session_destroy(); // destroy all session data
		?>		
	</section>
	
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
