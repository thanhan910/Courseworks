<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Index" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Index, Home" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>EZWeb Laptop - Home</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body id="index_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>


	<!-- Background Image -->
	<img src="styles/images/backgroundlaptop.jpg" alt="background laptop" width="1349" height="900" id="backgroundimageimg">		
	<!-- Reference: https://images.freecreatives.com/wp-content/uploads/2015/03/Huge-Backgrounds-33.jpg 
	Source: https://www.freecreatives.com/backgrounds/background-images-for-website-design.html -->
	<!-- I didn't know whether to use <img> as a background image or use background: url() as a background image, so I did both -->

	<!-- The introduction, which includes a welcome message, a search bar and a Click here to purchase button -->
	<!-- The welcome message. I styled this to look like Google. Reference: google.com  -->
	<main id="introduction">
		<h1>
			<!-- r, b, g, y mean red, blue, green, yellow -->
			<strong class="b">W</strong>
			<strong class="r">e</strong>
			<strong class="g">l</strong>
			<strong class="b">c</strong>
			<strong class="y">o</strong>
			<strong class="g">m</strong>
			<strong class="r">e</strong>
			<!-- I want to color the spacing part so that the space will have the same size as the letters -->
			<strong class="g">&nbsp;</strong>
			<strong class="b">t</strong>
			<strong class="r">o </strong>
			<strong class="g">&nbsp;</strong>
			<strong class="g">E</strong>
			<strong class="y">Z</strong>
			<strong class="b">W</strong>
			<strong class="r">e</strong>
			<strong class="y">b</strong>
			<strong class="g">!</strong>
		</h1>
		<!-- The introduction search bar. I put it in a section to make a block that fits -->
		<!-- I was going to add a button, but for the sake of the Assignment, I needed to minimize my workload -->
		<form action="product.html" id="introduction_search">
	    <input type="text" placeholder="Type here to search products, items, features..." name="q" size="70">
	  </form>
	  <!-- The introduction Click here button -->
	  <form action="product.html" id="introduction_clickhere">
	    <button type="submit" value="Click here to find and purchase a laptop!">Click here to find and purchase a laptop!</button>
	  </form>
  </main>
  
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
