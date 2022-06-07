<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Enquire" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Enquire" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Enquiry and Selection</title>
	<link rel="stylesheet" href="styles/style.css" />
	<script src="scripts/part2.js"></script>
</head>
<body id="enquire_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<h1 class="content_header">Laptop computer enquiry and selection form</h1>
	<hr />

	<h2 id="enquiry_form_header">Please fill in the form below:</h2>
	<hr />

	<!-- Product enquiry form. Linked to the PHP page -->
	<form method="post" action="payment.php" id="product_enquiry" novalidate="novalidate">
		<!-- First name -->
		<label for="first_name">First name</label> 
		<!-- pattern="[A_Za_z]{0,25}" -->
		<input type="text" name= "first_name" id="first_name" required="required" maxlength="25" size="25" placeholder="Maximum 25 letters" />
		<!-- Last name -->
		<label for="last_name">Last name</label> 
		<!-- pattern="[a_zA_Z\_]{0,25}" -->
		<input type="text" name= "last_name"  id="last_name"  required="required" maxlength="25" size="25" placeholder="Maximum 25 letters"/>
		<!-- Email address -->
		<label for="email_address">Email address</label>
		<input type="email" name= "email_address"  id="email_address" required="required" size="25" placeholder="example@email.domain" />
		<!-- Address fieldset -->
		<fieldset>
			<legend>Postal Address</legend>
			<label for="street_address">Street Address</label> 
			<input type="text" name= "street_address" id="street_address" maxlength="40" size="40" required="required" placeholder="Maximum 40 letters" />
			<label for="suburb_town">Suburb/town</label> 
			<input type="text" name= "suburb_town" id="suburb_town" maxlength="20" size="20" required="required" placeholder="Maximum 20 letters" />
			<label for="state">State</label> 
			<!--VIC,NSW,QLD,NT,WA,SA,TAS,ACT-->
			<select name="state" id="state" required="required">
				<option value="">Please select</option>		
				<option value="VIC">VIC</option>	
				<option value="NSW">NSW</option>
				<option value="QLD">QLD</option>
				<option value="NT">NT</option>
				<option value="WA">WA</option>
				<option value="SA">SA</option>
				<option value="TAS">TAS</option>
				<option value="ACT">ACT</option>
			</select>
			<label for="postcode">Postcode</label> 
			<!-- pattern="[0_9]{4}" I left this out so that the Error Message can be displayed-->
			<input type="text" name= "postcode"  id="postcode"  maxlength="4" size="4" required="required" placeholder="1234" />
		</fieldset>
		<!-- Phone number. Include placeholder (Most inputs include placeholders) -->
		<label for="phone_number">Phone number</label> 
		<!-- pattern="[0_9]{10}" I left this out so that the Error Message can be displayed-->
		<input type="text" name= "phone_number"  id="phone_number"   maxlength="10" size="10" required="required" placeholder="0123456789" />
		<!-- Preferred contact -->
		<fieldset id="preferred_contact">
			<legend>Preferred contact: </legend>
			<!-- I need to use span so that the label and input will stick together -->
			<div class="tick_box">
				<label for="preferemail" class="tick_box">Email</label> 
				<input type="radio" id="preferemail" class="tick_box" name="preferred_contact" required="required" value="Email" checked="checked"/>
			</div>
			<div class="tick_box">
				<label for="preferpost" class="tick_box">Post</label> 
				<input type="radio" id="preferpost" class="tick_box" name="preferred_contact" required="required" value="Post"/>
			</div>
			<div class="tick_box">
				<label for="preferphone" class="tick_box">Phone</label>
				<input type="radio" id="preferphone" class="tick_box" name="preferred_contact" required="required" value="Phone"/>
			</div>
		</fieldset>		
		<figure id="enquire_product_figure">
			<!-- The product image -->
			<img src="images/applelaptop.jpg" alt="Product picture" width="260" height="163" id="enquire_product_img">
			<figcaption id="enquire_product_figcaption"> </figcaption>
		</figure>
		<!-- Choose the laptop the user wants to enquire -->
		<label for="choose_product">Choose your laptop product: </label>
		<select name="choose_product" id="choose_product" required="required">
			<option value="">Choose product</option>	
			<option value="Apple Surface Pro X ($1,000)">Apple Surface Pro X ($1,000)</option>		
			<option value="IBM ThinkPad IQ 900 ($500)">IBM ThinkPad IQ 900 ($500)</option>
			<option value="Microsoft Macbook Air 20 ($800)">Microsoft Macbook Air 20 ($800)</option>
		</select>
		<!-- Choose number of products -->
		<label for="quantity">Number of laptops:</label> 
		<!-- pattern="[0_9]{1,}" I left this out so that the Error Message can be displayed-->
		<input type="text" name= "quantity"  id="quantity" size="4" placeholder="1,2,..." required="required"/>
		<!-- Choose the features -->
		<fieldset>
			<legend>Choose your laptop features: (optional)</legend>
			<!-- memory -->
			<fieldset id="memory">
				<legend>Memory</legend>
				<!-- I need to use div so that the label and input will stick together on a line -->
				<div class="tick_box">
					<label for="RAM8GB">8GB (+$10/laptop)</label>
					<input type="checkbox" id="RAM8GB" name="memory" value="8GB (+$10)" checked="checked"/>
				</div>
				<div class="tick_box">
					<label for="RAM16GB">16GB (+$20/laptop)</label>
					<input type="checkbox" id="RAM16GB" name="memory" value="16GB (+$20)"/>
				</div>
				<div class="tick_box">
					<label for="RAM32GB">32GB (+$30/laptop)</label>
					<input type="checkbox" id="RAM32GB" name="memory" value="32GB (+$30)"/>
				</div>
			</fieldset>
			<!-- storage -->
			<fieldset id="storage">
				<legend>Storage</legend>
				<div class="tick_box">
					<label for="Storage128GB">128GB (+$100/laptop)</label>
					<input type="checkbox" id="Storage128GB" name="storage" value="128GB (+$100)" checked="checked"/>
				</div>
				<div class="tick_box">
					<label for="Storage256GB">256GB (+$150/laptop)</label>
					<input type="checkbox" id="Storage256GB" name="storage" value="256GB (+$150)"/>
				</div>
				<div class="tick_box">
					<label for="Storage512GB">512GB (+$200/laptop)</label>
					<input type="checkbox" id="Storage512GB" name="storage" value="512GB (+$200)"/>
				</div>
				<div class="tick_box">
					<label for="Storage1TB">1TB (+$250/laptop)</label>
					<input type="checkbox" id="Storage1TB" name="storage" value="1TB (+$250)"/>
				</div>
			</fieldset>
			<!-- storage device -->
			<fieldset id="storage_device">
				<legend>Storage Device</legend>
				<div class="tick_box">
					<label for="StorageHDD">HDD (+$50/laptop)</label>
					<input type="checkbox" id="StorageHDD" name="storage_device" value="HDD (+$50)" checked="checked"/>
				</div>
				<div class="tick_box">
					<label for="StorageSSD">SSD (+$100/laptop)</label>
					<input type="checkbox" id="StorageSSD" name="storage_device" value="SSD (+$100)"/>
				</div>
			</fieldset>
			<!-- operating system -->
			<fieldset id="OS">
				<legend>Operating System</legend>
				<div class="tick_box">
					<label for="OSLinux">Linux (free)</label>
					<input type="checkbox" id="OSLinux" name="OS" value="Linux (free)" checked="checked"/>
				</div>
				<div class="tick_box">
					<label for="OSWindows">Windows (+$10/laptop)</label>
					<input type="checkbox" id="OSWindows" name="OS" value="Windows (+$10)" />
				</div>
				<div class="tick_box">
					<label for="OSmacOS">macOS (+$20/laptop)</label>
					<input type="checkbox" id="OSmacOS" name="OS" value="macOS (+$20)"/>
				</div>
				<div class="tick_box">
					<label for="OSChromeOS">ChromeOS (+$5/laptop)</label>
					<input type="checkbox" id="OSChromeOS" name="OS" value="ChromeOS (+$5)"/>
				</div>
			</fieldset>
		</fieldset>
		<!-- textarea -->
		<div id="enquire_textarea">
			<label for="write_more">More information: (optional)</label>
			<textarea id="write_more" name="write_more" placeholder="What else would you like to know about your product?" rows="5"></textarea>
		</div>
		<!-- the buttons -->
		<div id="enquire_buttons">
			<input type= "submit" value="Pay now"/>
			<input type= "reset" value="Reset"/>
		</div>
	</form>
	
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
