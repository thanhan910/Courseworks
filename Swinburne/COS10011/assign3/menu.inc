<!-- I kept using _html in body ids, it's still able to distinguish the big body id of the pages 
so many to code already -->
<nav class="top">
	<!-- This will let the user know which page the user is in (index.html) 
	The markup will be done in the CSS file  -->
	<a href="index.php" id="inthispage_index_html">Home</a> 
	<a href="product.php" id="inthispage_product_html">Product</a> 
	<a href="enquire.php" id="inthispage_enquire_html">Enquiry</a> 
	<a href="about.php" id="inthispage_about_html">About</a>
	<a href="manager.php" id="inthispage_manager_php">Manager</a>
	<a href="enhancements3.php" id="inthispage_enhancements_html">Enhancements 3</a>
	<!-- Search bar -->
	<form action="product.php">
		<!-- Search input -->
  	<input type="text" placeholder="Type here to search..." name="q" size="36">
  	<!-- Search button -->
  	<button type="submit" value="Search">Search</button>
	</form>
</nav>