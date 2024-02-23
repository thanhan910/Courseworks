<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Enhancements 2" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Enhancements 2" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Enhancements 2</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body id="enhancements_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<h1 class="content_header">Enhancements 2</h1>
	<hr />

	<h3 class="content_header">This is the old Enhancement 2 page of Assignment 2.</h3>
	<h4 class="content_header">Please go to <a href="enhancements3.php">enhancements3.php</a> to see the Enhancements for Assignment 3</h4>
	<hr />

	<!-- Main block -->
	<main>
		<!-- The requirements -->
		<h2>Here are the requirements of how to state my enhancements 2:</h2>
		<ol class="enhancements_requirements">
			<li>Briefly describe the interaction required to trigger the event and what a programmer has to do to implement the feature. (A reminder to your future self of what you have done.)</li>
			<li>Provide a hyperlink to the page where the enhancement is implemented in your Web site.</li>
			<li>Reference any third party sources used to create the extension/enhancement.</li> 
		</ol>

		<hr />

		<!-- Enhancements -->
		<h2>Here are my enhancements:</h2>

		<!-- Each section displays an enhancement I made, each seperated by an <hr /> -->

		<hr />

		<section>
			<h3>On every page, I dynamically styled the menu item for the current page, based on the page filename</h3>
			<ol>
				<li>A user needs to know which page he/she is in, so I colored the menu item of the page he/she is in with grey. I used an id="inthispage" and styled it in CSS.</li>
				<li>You can see it in every page, at the top navigation menu bar: <a href="enhancements2.php#inthispage">enhancements2.php#inthispage</a></li>
				<li>I do this by myself, so I don't know if there is any third party sources to reference.</li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>On payment.php, I pre-loaded the "Name on Credit Card" as a concatenation of the firstname and lastname, into the input field, to enable a user to change the value.</h3>
			<ol>
				<li>I added it in JavaScript so that the user can feel convenient. I added sessionStorage.FirstName with sessionStorage.LastName to get a FullName variable, and then store it in the value of Credit Card Name. I put that action in the store_hidden_input function, before the form's onsubmit event function. The value the user entered will still be read and processed.</li>
				<li>After filling the enquiry form in <a href="enquire.php">enquire.php</a>, you can see it in the credit card name: <a href="payment.php#credit_card_name">payment.php#credit-card-name</a></li>
				<li>I do this by myself, so I don't know if there is any third party sources to reference. So maybe I shall reference the Lecture of COS10011 from Swinburne University.</li>
			</ol>
		</section>

		<hr />


		<section>
			<h3>Some products doesn't have specific features, so I disabled those features in JavaScript.</h3>
			<ol>
				<li>I added it so that the user can avoid paying for unavailable features. I made the .style.display of the inputs and labels of those features be "none" when the user chose/changed the product.</li>
				<li>In the enquiry form of <a href="enquire.php#choose_product">enquire.php#choose-product</a>, you can see the features being hidden.</li>
				<li>I do this by myself, so I don't know if there is any third party sources to reference.</li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>In additition to the unavailabe features being disabled, I also made the window alert the user when he/she tries to change the product.</h3>
			<ol>
				<li>I added it so that the users can choose the features again if they want to. I added an alert in a function that is activated in the onchange event when the user chose/changed the product.</li>
				<li>In the enquiry form of <a href="enquire.php#choose_product">enquire.php#choose-product</a>, you can see the features being hidden.</li>
				<li>I do this by myself, so I don't know if there is any third party sources to reference.</li>
			</ol>
		</section>

		<hr />


		<section>
			<h3>When the user chooses a product, the product image will appear.</h3>
			<ol>
				<li>I added it so that the user can see the product he/she is paying for. I made the figure block display be none when there is no product chosen. After a product is chosen, the onchange event function will be activated, making the figure display the product image.</li>
				<li>In the enquiry form of <a href="enquire.php#choose_product">enquire.php#choose-product</a>, you can see it when you change the product.</li>
				<li>I do this by myself, so I don't know if there is any third party sources to reference.</li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>Others</h3>
			<ul>
				<li>I also included a search bar on every top menu:<a href="enhancements2.php#hdr">enhancements2.php#hdr</a>, so that the user can search something. I just add a form in it.</li>
				<li>If there are other enhancements that I didn't notice, please let me know.</li>
			</ul>
		</section>

	</main>

  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
