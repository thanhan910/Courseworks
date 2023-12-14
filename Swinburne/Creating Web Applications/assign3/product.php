<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Product" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Product" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Laptop Products</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body id="product_html">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<!-- This is the h1 header, the content header -->
	<h1 class="content_header">Laptop products for you</h1>
	<hr />

	<!-- The aside part of product.html. This will show the user how to choose a laptop -->
	<aside id="product_aside">
		<!-- The first hierarchically header h3 -->
		<h3>How to choose a laptop</h3>
		<!-- A section -->
		<section>
			<!-- The second hierarchically header h4 -->
			<h4>Here are the key specifications you should take notice:</h4>
			<!-- The ol list -->
			<ol>
				<li>Weight: 1kg, 2kg,...</li>
				<li>Display Size: 13.5", 14",...</li>
				<li>Processor: Intel, A113,...</li>
				<li>Battery: 4000mAh, 5000mAh,...</li>
			</ol>
		</section>
		<!-- Another section -->
		<section>
			<h4>Other than that, here are the laptop features that you can choose:</h4>
			<!-- The ul list -->
			<ul>
				<li>Memory: RAM 8GB, 16GB,...</li>
				<li>Storage: 128GB, 1TB,...</li>
				<li>Storage Device: HDD vs SSD</li>
				<li>Operating System: Windows, macOS,...</li>
			</ul>
		</section>
	</aside>

	<!-- the product cards -->

	<!-- Each product card is a section, so there must be a header in each card
	I checked on the validator, and it warns me that sections must have headers
	So if a block is just a container, I will use div instead of section -->

	<!-- Since I want the user to hover on the product container to see full information (so that the webpage will look fitter), I made a copy of the figure, table, buttons into a new product-info block to make it as the displaying part of the product container. The card is the main part which contains all info about the product. Hovering the container will make the info dissapear and the card appear, but the product-info and the product-figure are so identical the user won't notice.  -->

	<!-- The main part of the webpage - products information -->
	<main>
		<!-- This is a product info container. There are two sections: a product-info and a product-card -->
		<div class="product_container">
			<section class="product_info">
				<h4 class="product_name">Apple Surface Pro X</h4>
				<hr />
				<!-- The product info contains the figure and name of the laptop -->
				<!-- The product figure -->
				<figure class="product_figure">
					<!-- The product image -->
					<img src="images/applelaptop.jpg" alt="Apple Laptop" width="260" height="163">
					<!-- Source: https://images.fpt.shop/unsafe/fit-in/214x214/filters:quality(90):fill(white)/fptshop.com.vn/Uploads/Originals/2019/11/18/637096956683492064_MBP-16-touch-dd.png 
						Reference: https://fptshop.com.vn/may-tinh-xach-tay
						from: fptshop -->
					<!-- The product name -->
					<figcaption class="product_price">$1,000/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>Apple Surface Pro X</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>Apple</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.17 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>14 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>A113</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>6500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- a placeholer, user can click to see more details -->
				<p><em>Click here or hover to see more details</em></p>
			</section>
			<!-- The product card is also a link to the enquire.html page -->
			<section class="product_card">
				<h4 class="product_name">Apple Surface Pro X</h4>
				<hr />
				<!-- The product figure -->
				<figure class="product_figure">
					<!-- The product image -->
					<img src="images/applelaptop.jpg" alt="Apple Laptop" width="260" height="163">
					<!-- Source: https://images.fpt.shop/unsafe/fit-in/214x214/filters:quality(90):fill(white)/fptshop.com.vn/Uploads/Originals/2019/11/18/637096956683492064_MBP-16-touch-dd.png 
						Reference: https://fptshop.com.vn/may-tinh-xach-tay
						from: fptshop -->
					<!-- The product name -->
					<figcaption class="product_price">$1,000/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>Apple Surface Pro X</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>Apple</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.17 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>14 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>A113</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>6500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- product desription -->
				<section class="product_description">
					<!-- Product description -->
					<h4>Descrpition:</h4>
					<!-- The description is merely based on various wikipedia pages about laptops and phones
					Source: https://en.wikipedia.org/wiki/IPhone_12 -->
					<ul>
						<li>The Apple Surface Pro X is the latest laptop of the Surface Pro laptop computers series, the first and only portable computers series developed by Apple Inc. that supported the revolutionary Windows operating system. It is the twenty-fourth generation of the Surface Pro series, succeeding the Surface Pro W. It is designed, developed and marketed by Apple Inc, and was introduced in March 28th, 2021 at the iconic Apple Work Innovation Square. </li>
						<li>The major upgrades of the Surface Pro X over the Surface Pro W include the addition of A113 Quantum Processor chip, 6G support, the introduction of ColdFusion battery optimization, and an Operating System split screen transition where you can use different operating systems on a split screen. Similar to other Surface Pro laptops, the Surface Pro X supports all versions of macOS and Windows operating system. The laptop can have memory capacities range from 8 GB to 32 GB, and SSD storage up to 512 GB.</li>
					</ul>
				</section>
			</section>
		</div>
		<div class="product_container">
			<section class="product_info">
				<h4 class="product_name">IBM ThinkPad IQ 900</h4>
				<hr />
				<!-- The product info contains the figure and name of the laptop -->
				<!-- The product figure -->
				<figure class="product_figure">
					<img src="images/ibmlaptop.jpg" alt="IBM Laptop" width="260" height="166">
						<!-- Reference: https://dientuphongvu.com/bang-gia-laptop-lenovo-thinkpad-e470i5-7200u4gb-ddr4500gb14-hdwin10_20h10034vn-fpt-phan-phoi-phong-vu.htmljavascript:alert(document.lastModified) -->
					<!-- The product name -->
					<figcaption class="product_price">$500/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>IBM ThinkPad IQ 900</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>IBM</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.19 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>13.5 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>Intel Core i10</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>8500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- placeholder -->
				<p><em>Click here or hover to see more details</em></p>
			</section>
			<section class="product_card">
				<h4 class="product_name">IBM ThinkPad IQ 900</h4>
				<hr />
				<figure class="product_figure">
					<!-- The product figure -->
					<img src="images/ibmlaptop.jpg" alt="IBM Laptop" width="260" height="166">
					<!-- Reference: https://dientuphongvu.com/bang-gia-laptop-lenovo-thinkpad-e470i5-7200u4gb-ddr4500gb14-hdwin10_20h10034vn-fpt-phan-phoi-phong-vu.htmljavascript:alert(document.lastModified) -->
					<!-- The product name -->
					<figcaption class="product_price">$500/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>IBM ThinkPad IQ 900</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>IBM</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.19 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>13.5 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>Intel Core i10</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>8500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- product description -->
				<section class="product_description">
					<!-- Product description -->
					<h4>Description:</h4>
					<ul>
						<li>After reacquiring the successful ThinkPad portable computer line from Lenovo, IBM had further developed newer series of the PC line, and now, IBM has released its first ever series, the IBM ThinkPad IQ, with its first ever laptop, the IQ 900. It is the first ever ThinkPad laptop that has a quantum processing unit, the Intel Core i10, using the latest quantum computing technology developed in a collaboration of Intel, IBM and Google.</li>
						<li>Just like the previous ThinkPad models, the IQ 900 includes the world-class keyboard that everyone loves. It also has the OLED screen with a diagonal of 14 inches. The model currently has versions with RAM capacities range from 8 GB to 32 GB, and storage capacities range from 128 GB to 512GB SSD or 1TB HDD with 256GB SSD.</li>
						<li>As can be seen from the name, all versions will support the newest Windows 10 version that includes a new 900 IQ Cortana Artificial Intelligence system. It will also include 6G support, Carl-Bot security check and ColdFission battery optimization.</li>
					</ul>
				</section>
			</section>
		</div>
		<div class="product_container">
			<section class="product_info">
				<h4 class="product_name">Microsoft Macbook Air 20</h4>
				<hr />
				<figure class="product_figure">
					<!-- The product image -->
					<img src="images/microsoftlaptop.jpg" alt="Microsoft Laptop" width="260" height="169">
					<!-- Reference:
					https://mac24h.vn/ice-bluesurface-laptop-go-12.4-i5-1035g1-8gb-256gb-ssd.html-->
					<!-- The product name -->
					<figcaption class="product_price">$800/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>Microsoft Macbook Air 20</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>Microsoft</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.23 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>14 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>Intel Core i8</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>7500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- placeholder -->
				<p><em>Click here or hover to see more details</em></p>
			</section>
			<section class="product_card">
				<h4 class="product_name">Microsoft Macbook Air 20</h4>
				<hr />
				<figure class="product_figure">
					<!-- The product image -->
					<img src="images/microsoftlaptop.jpg" alt="Microsoft Laptop" width="260" height="169">
					<!-- Reference:
					https://mac24h.vn/ice-bluesurface-laptop-go-12.4-i5-1035g1-8gb-256gb-ssd.html-->
					<!-- The product name -->
					<figcaption class="product_price">$800/laptop</figcaption>
				</figure>
				<!-- The product table of specifications -->
				<table class="product_table_specs">
					<caption><strong>Specifications</strong></caption>
					<thead>
						<tr>
							<th>Name</th>
							<th>Microsoft Macbook Air 20</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Manufacturer</td>
							<td>Microsoft</td>
						</tr>
						<tr>
							<td>Weight</td>
							<td>1.23 kg</td>
						</tr>
						<tr>
							<td>Display Size</td>
							<td>14 inches</td>
						</tr>
						<tr>
							<td>Processor</td>
							<td>Intel Core i8</td>
						</tr>
						<tr>
							<td>Battery</td>
							<td>7500mAh</td>
						</tr>
					</tbody>
				</table>
				<!-- The product buttons -->
				<div class="product_buttons">
					<form action="enquire.html">
						<button type="submit" value="Buy now!">Buy now!</button>
					</form>
					<form action="enquire.html">
						<button type="submit" value="Enquire">Enquire</button>
					</form>
				</div>
				<!-- product description -->
				<section class="product_description">
					<!-- Product description -->
					<h4>Description:</h4>
					<!-- The description is merely based on various wikipedia pages about laptops and phones
					Source: https://en.wikipedia.org/wiki/IPhone_12 -->
					<ul>
						<li>The Microsoft MacBook Air 20 is a portable computer developed by Microsoft. It is the fifth generation of Microsoft&apos;s infamous MacBook Air family, succeeding the MacBook Air 10, and it is the first ever MacBook computer that supports Chrome OS. It is designed, developed and marketed by Microsoft Inc., and was introduced in March 28th, 2021 at the iconic Microsoft Golden Gate Hall.</li>
						<li>The major upgrades of the MacBook Air 20 over its predecessors include the addition of a thin 14 inches Graphene OLED screen. It also provides 6G support, Carl-Bot security check, and an Operating System split screen transition where you can use different operating systems on a split screen. Similar to other MacBook Air laptop models, the MacBook Air 20 supports all versions of Windows operating system. Macbook Air 20 currently support memory capacity ranges from 8 GB to 32 GB, and SSD storage up to 1 TB.</li>
					</ul>
				</section>
			</section>
		</div>

		<!-- The products spectfications and features big table -->
		<table id="product_table">
			<!-- Caption is an h2 header -->
			<caption>
				<h2>Specifications and Features</h2>
			</caption>
			<thead>
				<tr>
					<th>Laptop Features</th>
					<th>Apple Surface Pro X</th>
					<th>IBM ThinkPad IQ 900</th>
					<th>Microsoft Macbook Air 20</th>
				</tr>
			</thead>
			<tbody>
				<!-- The table cells include a list of specifications and features of the laptops that the user can choose -->
				<tr>
					<td>Manufacturer</td>
					<td>
						<ul>
							<li>Apple</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>IBM</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Microsoft</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Weight</td>
					<td>
						<ul>
							<li>1.17 kg</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>1.19 kg</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>1.23 kg</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Display size</td>
					<td>
						<ul>
							<li>14 inches</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>13.5 inches</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>14 inches</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Processor</td>
					<td>
						<ul>
							<li>A113</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Intel Core i10</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Intel Core i8</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Battery</td>
					<td>
						<ul>
							<li>6500mAh</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>8500mAh</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>7500mAh</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Memory</td>
					<td>
						<ul>
							<li>8GB</li>
							<li>16GB</li>
							<li>32GB</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>8GB</li>
							<li>16GB</li>
							<li>32GB</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>8GB</li>
							<li>16GB</li>
							<li>32GB</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Storage</td>
					<td>
						<ul>
							<li>128GB</li>
							<li>256GB</li>
							<li>512GB</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>128GB</li>
							<li>256GB</li>
							<li>512GB</li>
							<li>1TB</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>256GB</li>
							<li>512GB</li>
							<li>1TB</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Storage Device</td>
					<td>
						<ul>
							<li>SSD</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>SSD</li>
							<li>HDD</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>SSD</li>
							<li>HDD</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>Operating System</td>
					<td>
						<ul>
							<li>macOS</li>
							<li>Windows</li>
							<li>Linux</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Windows</li>
							<li>ChromeOS</li>
							<li>Linux</li>
						</ul>
					</td>
					<td>
						<ul>
							<li>Windows</li>
							<li>ChromeOS</li>
							<li>Linux</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</main>

  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
