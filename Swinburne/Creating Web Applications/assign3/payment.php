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
	// set the payment
	$_SESSION["in_payment_php"] = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Payment" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Payment" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Payment</title>
	<link rel="stylesheet" href="styles/style.css" />
	<script src="scripts/payment.js"></script>
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

	<h1 class="content_header">Payment</h1>
	<hr />

	<h3 class="content_header">Please check your information and fill in your payment details:</h3>
	<hr />

	<!-- Product enquiry form. Linked to the PHP page -->
	<!-- https://mercury.swin.edu.au/it000000/formtest.php -->
	<form method="post" action="process_order.php" novalidate="novalidate" id="payment_form">
		<!-- All inputs to be submitted to php -->
		<input type="hidden" id="first_name" name="first_name" />
		<input type="hidden" id="last_name" name="last_name" />
		<input type="hidden" id="email_address" name="email_address" />
		<input type="hidden" id="street_address" name="street_address" />
		<input type="hidden" id="suburb_town" name="suburb_town" />
		<input type="hidden" id="state" name="state" />
		<input type="hidden" id="postcode" name="postcode" />
		<input type="hidden" id="phone_number" name="phone_number" />
		<input type="hidden" id="preferred_contact" name="preferred_contact" />
		<input type="hidden" id="choose_product" name="choose_product" />
		<input type="hidden" id="memory" name="memory" />
		<input type="hidden" id="storage" name="storage" />
		<input type="hidden" id="storage_device" name="storage_device" />
		<input type="hidden" id="OS" name="OS" />
		<input type="hidden" id="write_more" name="write_more" />
		<input type="hidden" id="cost_per_laptop" name="cost_per_laptop"/>
		<input type="hidden" id="quantity" name="quantity" />
		<input type="hidden" id="order_cost" name="order_cost"/>
		<!-- User information -->
		<fieldset>
			<legend>Your information</legend>
			<!-- First name -->
			<p>First name: <span id="payment_first_name"></span></p> 
			<!-- Last name -->
			<p>Last name: <span id="payment_last_name"></span></p> 
			<!-- Email address -->
			<p>Email address: <span id="payment_email_address"></span></p>
			<!-- Postal Address -->
			<fieldset>
				<legend>Postal Address</legend>
				<!-- Address fieldset -->
				<p>Street Address: <span id="payment_street_address"></span></p> 
				<!-- Address fieldset -->
				<p>Suburb/Town: <span id="payment_suburb_town"></span></p> 
				<!-- Address fieldset -->
				<p>State: <span id="payment_state"></span></p> 
				<!-- Address fieldset -->
				<p>Postcode: <span id="payment_postcode"></span></p> 
			</fieldset>
			<!-- Phone number. Include placeholder (Most inputs include placeholders) -->
			<p>Phone number: <span id="payment_phone_number"></span></p> 
			<!-- Preferred contact -->
			<p>Preferred contact: <span id="payment_preferred_contact"></span></p> 
		</fieldset>
		<!-- Laptop information -->
		<fieldset>
			<legend>Laptop details</legend>
			<figure id="payment_product_figure">
				<!-- The product image -->
				<img src="images/applelaptop.jpg" alt="Product picture" width="260" height="163" id="payment_product_img">
				<figcaption id="payment_product_figcaption"> </figcaption>
			</figure>
			<!-- Choose the laptop the user wants to enquire -->
			<p>Laptop: <span id="payment_choose_product"></span></p>
			<!-- Number of products -->
			<p>Number of laptops: <span id="payment_quantity">0</span></p>
			<!-- Added features -->
			<fieldset>
				<!-- If the user didn't choose anything, there will be a "none" displayed -->
				<legend>Added features for each laptop: </legend>
				<!-- memory -->
				<p>Memory: <span id="payment_memory">none</span></p> 
				<!-- storage -->
				<p>Storage: <span id="payment_storage">none</span></p> 
				<!-- storage device -->
				<p>Storage device: <span id="payment_storage_device">none</span></p> 
				<!-- operating system -->
				<p>Operating System: <span id="payment_OS">none</span></p> 
			</fieldset>
			<!-- more information -->
			<fieldset>
				<legend>More information</legend>
				<!-- If the user didn't write anything, there will be a "none" displayed -->
				<span id="payment_write_more">none</span>
			</fieldset>
		</fieldset>
		<!-- credit card -->
		<fieldset>
			<legend>Payment details</legend>
			<!-- Cost per Laptop -->
			<p>Cost per laptop: $<span id="payment_cost_per_laptop">0</span></p>
			<!-- Number of products -->
			<p>Number of laptops: <span id="payment_quantity_2">0</span></p>
			<!-- Total Price -->
			<p>Total Price: $<span id="payment_total_price">0</span></p> 
			<!-- Credit card type -->
			<label>Credit card type:</label>
			<select name="credit_card_type" id="credit_card_type" required="required">
				<option value="">Please select</option>		
				<option value="Visa">Visa</option>	
				<option value="Mastercard">Mastercard</option>
				<option value="American Express">American Express</option>
			</select>
			<!-- name on credit card -->
			<label for="credit_card_name">Name on credit card:</label>
			<input name="credit_card_name" type="text" id="credit_card_name" placeholder="Maximum 40 characters" maxlength="40" size="40" required="required"/>
			<!-- credit card number -->
			<!-- exactly 15 or 16 digits. 
			Credit card numbers must be checked against the selected card type 
			according to the following rules:
			Visa cards have 16 digits and start with a 4
			MasterCard have 16 digits and start with digits 51 through to 55
			American Express has 15 digits and starts with 34 or 37. -->
			<label for="credit_card_number">Credit card number:</label>
			<input name="credit_card_number" type="text" id="credit_card_number" maxlength="16" size="25" required="required" placeholder="15-16 digits"/>
			<!-- credit card expiry date -->
			<label for="credit_card_expiry_date">Credit card expiry date:</label>
			<input name="credit_card_expiry_date" type="text" id="credit_card_expiry_date" placeholder="mm-yy" required="required" size="25" maxlength="5"/>
			<!-- card verification value -->
			<label for="credit_card_verification_value">Card verification value:</label>
			<input name="credit_card_verification_value" type="text" id="credit_card_verification_value" placeholder="CVV" size="25"/>
		</fieldset>
		<!-- the buttons -->
		<div id="payment_buttons">
			<input type= "submit" name="payment_submit" id="payment_submit" value="Check Out"/>
			<input type= "reset" value="Reset"/>
			<button type="button" id="payment_cancelButton">Cancel Order</button>
		</div>
		
	</form>
	
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
