<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Enhancements 3" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Enhancements 3" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Enhancements 3</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<!-- I kept using _html in body ids, it's still able to distinguish the big body id of the pages -->
<body id="enhancements_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<h1 class="content_header">Enhancements 3</h1>
	<hr />

	<!-- Main block -->
	<main>
		<!-- The requirements -->
		<h2>Here are the requirements of how to state my enhancements 3:</h2>
		<ol class="enhancements_requirements">
			<li>What it does and how it goes beyond the specified requirements.</li>
			<li>What does a programmer have to do to implement the feature.
				(A reminder to your future self of what you have done.)</li>
			<li>Reference any third party sources used to create the extension/enhancement.</li> 
		</ol>

		<hr />

		<!-- Enhancements -->
		<h2>Here are my enhancements:</h2>

		<!-- Each section displays an enhancement I made, each seperated by an <hr /> -->

		<hr />

		<section>
			<h3>Display total cost in ascending/descending order</h3>
			<ol>
				<li>The requirements asked me to sort the orders by total cost, but not in what order. So I divided the Sort by total cost into 2 options: Ascending and Descending</li>
				<li>You can see it in <a href="manager.php">manager.php</a>. I used ASC and DESC in mysqli queries, each at the end of the query.</li>
				<li>Reference: <a href="https://www.sqlservertutorial.net/sql-server-basics/sql-server-order-by/">https://www.sqlservertutorial.net/sql-server-basics/sql-server-order-by/</a></li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>Most popular products</h3>
			<ol>
				<li>There are no requirements for displaying the Most popular products, so I added the option in <a href="manager.php">manager.php</a>.</li>
				<li>I used COUNT(choose_product) to count the number of orders that has a particular product. Then I used $row[COUNT(choose_product)] to read the output. Then I displayed all the output received in a list.</li>
				<li>Reference: <a href="https://www.w3schools.com/sql/sql_count_avg_sum.asp">https://www.w3schools.com/sql/sql_count_avg_sum.asp</a></li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>Revenue report</h3>
			<ol>
				<li>There are no requirements for reporting revenue, so I added the option in <a href="manager.php">manager.php</a>.</li>
				<li>I used SUM(order_cost) to calculate the total revenue. I also used WHERE to calculate pending revenue and real time current revenue, based on the order status.</li>
				<li>Reference: <a href="https://www.w3schools.com/sql/sql_count_avg_sum.asp">https://www.w3schools.com/sql/sql_count_avg_sum.asp</a></li>
			</ol>
		</section>

		<hr />

		<section>
			<h3>Block direct url</h3>
			<ol>
				<li>Although the hint has been referred in the Requirements, I believe that the method I am about to show you is worth being called an enhancement. You can try it by clicking here: <a href="enquire.php">enquire.php</a>, <a href="payment.php">payment.php</a>, <a href="process_order.php">process_order.php</a>, <a href="fix_order.php">fix_order.php</a>, <a href="receipt.php">receipt.php</a>.</li>
				<li>I used isset($_SESSION["in_process_order_php"]), etc., to check whether the user has filled the form yet.</li>
				<li>I did this by myself, so I don't know if there are any references to this method :)</li>
			</ol>
		</section>

		<section>
			<h3>Search bar</h3>
			<ol>
				<li>I included a search bar in the menu of each page: <a href="enhancements3.php">enhancements3.php</a>.</li>
				<li>I didn't have time to include PHP yet, so I just linked it to the product.php page. There are only 3 products to choose from anyway :).</li>
				<li>I did this by myself, so I don't know if there are any references to this method.</li>
			</ol>
		</section>

	</main>

  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
