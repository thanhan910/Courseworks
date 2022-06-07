<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - About" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, About" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>About me</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body id="about_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<!-- h1 content header -->
	<h1 class="content_header">About me</h1>
	<hr />

	<!-- My figure -->
	<figure id="author_image">
		<!-- My image -->
		<img src="images/nguyenthanhan.jpg" alt="Thanh An's Image" width="205" height="200">
		<figcaption>A picture of me!</figcaption>
	</figure>

	<!-- My information, listed as required -->
	<dl id="author_info">
		<dt><strong>Name:</strong></dt>
		<dd>Thanh An Nguyen</dd>
		<dt><strong>Student ID:</strong></dt>
		<dd>s103125896</dd>
		<dt><strong>Course:</strong></dt>
		<dd>Bachelor of Computer Science</dd>
		<dt><strong>Email:</strong></dt>
		<dd><a href="mailto:103125896@student.swin.edu.au" class="email">103125896@student.swin.edu.au</a></dd>
	</dl>

	<hr />

	<!-- My timetable. I will display my classes on a timetable, each as consecutive cells in a column.
	Each class will span from the start date to the end date, therefore rowspans will be 2, 4, or 6  -->
	<!-- I only go to a class from Monday to Friday, so only days from Monday to Friday are shown  -->
	<table id="timetable">
		<caption>
			<h2>My Timetable</h2>
		</caption>
		<thead>
			<tr>
				<th>Time</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>10:00</td>
				<td></td>
				<td rowspan="4" class="cos10009">COS10009 - Live Online</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>10:30</td>
				<td></td>
				<!-- no cell -->
				<td></td>
				<td rowspan="4" class="cos10009">COS10009 - Lab 1 - Help Desk Sessions</td>
				<td rowspan="4" class="cos10009">COS10009 - Workshop 1</td>
			</tr>
			<tr>
				<td>11:00</td>
				<td></td>
				<!-- no cell -->
				<td></td>
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>11:30</td>
				<td rowspan="4" class="cos10011">COS10011 - Live Online</td>
				<!-- no cell -->
				<td></td>
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>12:00</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>12:30</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<td rowspan="4" class="cos10009">COS10009 - Lab 2 - Tutorial Online</td>
				<td rowspan="4" class="cos10009">COS10009 - Workshop 2 Online</td>
			</tr>
			<tr>
				<td>13:00</td>
				<!-- no cell -->
				<td></td>
				<td rowspan="4" class="cos10003">COS10003 - Live Online</td>
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>13:30</td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>14:00</td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<!-- no cell -->
				<!-- no cell -->
			</tr>
			<tr>
				<td>14:30</td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<td rowspan="4" class="cos10003">COS10003 - Tutorial Online</td>
				<td></td>
			</tr>
			<tr>
				<td>15:00</td>
				<td></td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
			<tr>
				<td>15:30</td>
				<td></td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
			<tr>
				<td>16:00</td>
				<td></td>
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
			<tr>
				<td>16:30</td>
				<td rowspan="2" class="cos10011">COS10011 - Lab Online</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>17:00</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>17:30</td>
				<td rowspan="6" class="tne10005">TNE10005 - Lab Online</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>18:00</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>18:30</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<td rowspan="4" class="tne10005">TNE10005 - Live Online</td>
				<td></td>
			</tr>
			<tr>
				<td>19:00</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
			<tr>
				<td>19:30</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
			<tr>
				<td>20:00</td>
				<!-- no cell -->
				<td></td>
				<td></td>
				<!-- no cell -->
				<td></td>
			</tr>
		</tbody>
	</table>

	<section id="about_more_information">
		<hr />
		<h2 class="content_header">More information</h2>
		<hr />
		<ul>
			<li>
				<p>I am currently in Hanoi, Vietnam. The timzone here is UTC+7.</p>
			</li>
			<li>
				<p>I am currently studying four base units for my Bachelor of Computer Science Course:</p>
				<ol>
					<li>COS10003: Computer and Logic Essentials</li>
					<li>COS10009: Introduction to Programming</li>
					<li>COS10011: Creating Web Applications</li>
					<li>TNE10005: Network Administration</li>
				</ol>
			</li>
			<li>
				<p>About my first major, I am wondering between Data Science, Software Development and Software Design. My favorite subject in high schools is mathematics. I like math, algorithms and data structures, but I also want to build and invent things like software.</p>
			</li>
			<li>
				<p>For more information, you can email me at <a href="mailto:103125896@student.swin.edu.au" class="email">103125896@student.swin.edu.au</a>.</p>
			</li>
		</ul>
	</section>
	
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
