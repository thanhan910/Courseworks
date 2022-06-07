<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Assignment 3: Laptop and Computer Purchase Website - Manager" />
	<meta name="keywords" content="Assignment 3, Laptop, Computer, Purchase, Manager" />
	<meta name="author" content="Thanh An Nguyen" />
	<title>Managers Order Report</title>
	<link rel="stylesheet" href="styles/style.css" />
</head>
<body id="manager_php">
	<!-- Header -->
	<?php
	include "header.inc";
	?>
	<!-- Top Navigation Menu -->
	<?php
	include "menu.inc";
	?>

	<!-- h1 content header -->
	<h1 class="content_header">Managers Order Report</h1>
	<hr />

	<!-- The web page should give the manager the option to display:
	All orders
	Orders for a customer based on their name
	Orders for a particular product
	Orders that are pending
	Orders sorted by total cost -->
	<aside>
		<form method="post" action="manager.php">
			<input type="submit" name="manager_orders" value="All orders" /><br />
			<input type="submit" name="manager_customer_name" value="Orders for a customer based on their name" /><br />
			<input type="submit" name="manager_orders" value="Orders for Apple Surface Pro X" /><br />
			<input type="submit" name="manager_orders" value="Orders for IBM ThinkPad IQ 900" /><br />
			<input type="submit" name="manager_orders" value="Orders for Microsoft Macbook Air 20" /><br />
			<input type="submit" name="manager_orders" value="Orders that are pending" /><br />
			<input type="submit" name="manager_orders" value="Orders sorted by total cost - Ascending" /><br />
			<input type="submit" name="manager_orders" value="Orders sorted by total cost - Descending" /><br />
			<input type="submit" name="manager_most_popular_products" value="Most popular products" /><br />
			<input type="submit" name="manager_revenue" value="Reports about revenue" /><br />
		</form>
	</aside>
	<main>
		<?php
			// connection info
			require_once("settings.php"); 
			$conn = @mysqli_connect(
				$host,
				$user,
				$pwd,
				$sql_db
			);
			$sql_table = "orders";
			// Checks if connection is successful
			if(!$conn) {
				echo "<p>Database connection failure</p>";
			}
			else { // Upon successful connection
				if(isset($_POST["manager_orders"])) {
					$manager_orders = $_POST["manager_orders"];
					// Set up the SQL command
					switch($manager_orders) {
						case "All orders":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table;";
							break;
						case "Orders sorted by total cost - Descending":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table 
								ORDER BY order_cost DESC;";
							// Reference: https://www.sqlservertutorial.net/sql-server-basics/sql-server-order-by/
							break;
						case "Orders sorted by total cost - Ascending":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table 
								ORDER BY order_cost ASC;";
							break;
						case "Orders that are pending":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table WHERE order_status = 'PENDING';";
							break;
						case "Orders for Apple Surface Pro X":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table WHERE choose_product LIKE 'Apple%';";
							break;
						case "Orders for IBM ThinkPad IQ 900":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table WHERE choose_product LIKE 'IBM%';";
							break;
						case "Orders for Microsoft Macbook Air 20":
							$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table WHERE choose_product LIKE 'Microsoft%';";
							break;
					}
					// execute the query and store result into the result pointer
					$result = mysqli_query($conn, $query);
					// checks if the execution was successful
					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						// Display the retrieved records
						echo "<table border=\"1\">\n";
						echo "<tr>\n "
							."<th scope=\"col\">ID</th>\n "
							."<th scope=\"col\">Date</th>\n  "
							."<th scope=\"col\">First name</th>\n"
							."<th scope=\"col\">Last name</th>\n"
							."<th scope=\"col\">Laptop</th>\n "
							."<th scope=\"col\">Memory</th>\n  "
							."<th scope=\"col\">Storage</th>\n"
							."<th scope=\"col\">Storage Device</th>\n"
							."<th scope=\"col\">OS</th>\n "
							."<th scope=\"col\">Additional Information</th>\n  "
							."<th scope=\"col\">Quantity</th>\n"
							."<th scope=\"col\">Cost per Laptop</th>\n"
							."<th scope=\"col\">Total Cost</th>\n"
							."<th scope=\"col\">Status</th>\n "
							."<th scope=\"col\">Option</th>\n "
							."</tr>\n";

						// retrieve current record pointed by the result pointer
						while ($row = mysqli_fetch_assoc($result)) {
							$order_id = $row["order_id"];
							$order_date = date("Y-m-d",$row["order_time"]);
							$first_name = $row["first_name"];
							$last_name = $row["last_name"];
							$choose_product = $row["choose_product"];
							$memory = $row["memory"];
							$storage = $row["storage"];
							$storage_device = $row["storage_device"];
							$OS = $row["OS"];
							$write_more = $row["write_more"];
							$quantity = number_format($row["quantity"],0,".",",");
							$cost_per_laptop = number_format($row["cost_per_laptop"],0,".",",");
							$order_cost = number_format($row["order_cost"],0,".",",");
							$order_status = $row["order_status"];
							echo "<tr>\n";
							echo "<td>", $order_id,"</td>\n ";
							echo "<td>", $order_date,"</td>\n ";
							echo "<td>", $first_name,"</td>\n ";
							echo "<td>", $last_name,"</td>\n ";
							echo "<td>", $choose_product,"</td>\n ";
							echo "<td>", $memory,"</td>\n ";
							echo "<td>", $storage,"</td>\n ";
							echo "<td>", $storage_device,"</td>\n ";
							echo "<td>", $OS,"</td>\n ";
							echo "<td>", $write_more,"</td>\n ";
							echo "<td>", $quantity,"</td>\n ";
							echo "<td>", $cost_per_laptop,"</td>\n ";
							echo "<td>", $order_cost,"</td>\n ";
							echo "<td>", $order_status,"</td>\n ";
							echo "<td>";
							echo '<form method="post" action="manager.php">'
								.'<select name="update_order_status">'	
								.'<option value="PENDING">PENDING</option>'	
								.'<option value="FULFILLED">FULFILLED</option>'
								.'<option value="PAID">PAID</option>'
								.'<option value="ARCHIVED">ARCHIVED</option>'
								.'</select>'
								.'<input type="hidden" value='
								.$order_id
								.' name="update_order_status_id" />'
								.'<input type="submit" value="Update" />'
								.'</form>';
							if($order_status == "PENDING") {
								echo '<form method="post" action="manager.php">'
									.'<input type="hidden" name="manager_cancel_orders" value='
									.$order_id 
									.' />'
									.'<input type="submit" value="Cancel" />'
									.'</form>';
							}
							echo "</td>\n ";
							echo "</tr>\n ";
						}
						echo "</table>\n ";
						// Frees up the memory, after using the result pointer
						mysqli_free_result($result);
					} // if successful query operation
					// close the database connection
					
				}
				if(isset($_POST["manager_cancel_orders"])) {
					$order_id = $_POST["manager_cancel_orders"];					
					$query = "DELETE FROM $sql_table WHERE order_id = $order_id;";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						echo "<p class='manager_answer'>Successfully cancelled order with ID: ", $order_id ,"</p>";
					} // if successful query operation
				}
				if(isset($_POST["manager_customer_name"])) {
					echo "<form method=\"post\" action=\"manager.php\">"
						."<input type=\"text\" name=\"search_customer_name\" class='customer_name_search_box' placeholder='Search orders by customer name' />"
						."<input type=\"submit\" value=\"Search\" class='customer_name_search_box' />"
						."</form>";
				}

				if(isset($_POST["search_customer_name"])) {
					$customer_name = $_POST["search_customer_name"];

					$query = "SELECT 
								order_id,
								order_time,
								first_name,
								last_name,
								choose_product,
								memory,
								storage,
								storage_device,
								OS,
								write_more,
								cost_per_laptop,
								quantity,
								order_cost,
								order_status
								FROM $sql_table 
								WHERE (first_name LIKE '{$customer_name}%'
								OR last_name LIKE '{$customer_name}%');";

					$result = mysqli_query($conn, $query);

					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						// Begin Display table
						echo "<table border=\"1\">\n";
						echo "<tr>\n "
							."<th scope=\"col\">ID</th>\n "
							."<th scope=\"col\">Date</th>\n  "
							."<th scope=\"col\">First name</th>\n"
							."<th scope=\"col\">Last name</th>\n"
							."<th scope=\"col\">Laptop</th>\n "
							."<th scope=\"col\">Memory</th>\n  "
							."<th scope=\"col\">Storage</th>\n"
							."<th scope=\"col\">Storage Device</th>\n"
							."<th scope=\"col\">OS</th>\n "
							."<th scope=\"col\">Additional Information</th>\n  "
							."<th scope=\"col\">Quantity</th>\n"
							."<th scope=\"col\">Cost per Laptop</th>\n"
							."<th scope=\"col\">Total Cost</th>\n"
							."<th scope=\"col\">Status</th>\n "
							."<th scope=\"col\">Option</th>\n "
							."</tr>\n";

						// retrieve current record pointed by the result pointer
						while ($row = mysqli_fetch_assoc($result)) {
							$order_id = $row["order_id"];
							$order_date = date("Y-m-d",$row["order_time"]);
							$first_name = $row["first_name"];
							$last_name = $row["last_name"];
							$choose_product = $row["choose_product"];
							$memory = $row["memory"];
							$storage = $row["storage"];
							$storage_device = $row["storage_device"];
							$OS = $row["OS"];
							$write_more = $row["write_more"];
							$quantity = number_format($row["quantity"],0,".",",");
							$cost_per_laptop = number_format($row["cost_per_laptop"],0,".",",");
							$order_cost = number_format($row["order_cost"],0,".",",");
							$order_status = $row["order_status"];
							echo "<tr>\n";
							echo "<td>", $order_id,"</td>\n ";
							echo "<td>", $order_date,"</td>\n ";
							echo "<td>", $first_name,"</td>\n ";
							echo "<td>", $last_name,"</td>\n ";
							echo "<td>", $choose_product,"</td>\n ";
							echo "<td>", $memory,"</td>\n ";
							echo "<td>", $storage,"</td>\n ";
							echo "<td>", $storage_device,"</td>\n ";
							echo "<td>", $OS,"</td>\n ";
							echo "<td>", $write_more,"</td>\n ";
							echo "<td>", $quantity,"</td>\n ";
							echo "<td>", $cost_per_laptop,"</td>\n ";
							echo "<td>", $order_cost,"</td>\n ";
							echo "<td>", $order_status,"</td>\n ";
							echo "<td>";
							echo '<form method="post" action="manager.php">'
								.'<select name="update_order_status">'	
								.'<option value="PENDING">PENDING</option>'	
								.'<option value="FULFILLED">FULFILLED</option>'
								.'<option value="PAID">PAID</option>'
								.'<option value="ARCHIVED">ARCHIVED</option>'
								.'</select>'
								.'<input type="hidden" value='
								.$order_id
								.' name="update_order_status_id" />'
								.'<input type="submit" value="Update" />'
								.'</form>';
							if($order_status == "PENDING") {
								echo '<form method="post" action="manager.php">'
									.'<input type="hidden" name="manager_cancel_orders" value='
									.$order_id 
									.' />'
									.'<input type="submit" value="Cancel" />'
									.'</form>';
							}
							echo "</td>\n ";
							echo "</tr>\n ";
						} 
						echo "</table>\n ";
						// End Display table
						// Frees up the memory, after using the result pointer
						mysqli_free_result($result);
					}
				}

				if(isset($_POST["update_order_status"]) 
					&& isset($_POST["update_order_status_id"])) {
					$order_status = $_POST["update_order_status"];
					$order_id = $_POST["update_order_status_id"];
					$query = "UPDATE $sql_table 
					SET order_status = '{$order_status}'
					WHERE order_id = $order_id;";

					$result = mysqli_query($conn, $query);

					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						echo "<p class='manager_answer'>Successfully updated order ID: ",$order_id," to status: ",$order_status,"</p>";
					}
				}

				if(isset($_POST["manager_most_popular_products"])) {
					// Apple
					$query = "SELECT COUNT(choose_product)
						FROM $sql_table
						WHERE choose_product LIKE 'Apple%';";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$number_of_Apple = $row["COUNT(choose_product)"];
						}
						mysqli_free_result($result);
					}
					// IBM
					$query = "SELECT COUNT(choose_product)
						FROM $sql_table
						WHERE choose_product LIKE 'IBM%';";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$number_of_IBM = $row["COUNT(choose_product)"];
						}
						mysqli_free_result($result);
					}
					// Microsoft
					$query = "SELECT COUNT(choose_product)
						FROM $sql_table
						WHERE choose_product LIKE 'Mirosoft%';";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$number_of_Microsoft = $row["COUNT(choose_product)"];
						}
						mysqli_free_result($result);
					}
					// return number of purchase of each laptop
					echo "<section class='manager_answer'>"
					."<h3>Laptops by number of user preferrence:</h3>"
					."<p>Apple Surface Pro X: ", $number_of_Apple,"</p>"
					."<p>IBM Thinkpad IQ 900: ", $number_of_IBM,"</p>"
					."<p>Microsoft Macbook Air 20: ", $number_of_Microsoft,"</p>"
					."</section>";
				}

				if(isset($_POST["manager_revenue"])) {
					// estimated revenue
					$query = "SELECT SUM(order_cost)
						FROM $sql_table;";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p class='manager_answer'>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$total_revenue = $row["SUM(order_cost)"];
						}
						mysqli_free_result($result);
					}
					// real revenue
					$query = "SELECT SUM(order_cost)
						FROM $sql_table
						WHERE order_status != 'PENDING';";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p class='manager_answer'>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$real_revenue = $row["SUM(order_cost)"];
						}
						mysqli_free_result($result);
					}
					// pending revenue
					$query = "SELECT SUM(order_cost)
						FROM $sql_table
						WHERE order_status = 'PENDING';";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						echo "<p class='manager_answer'>Something is wrong with ", $query, "</p>";
					}
					else {
						while ($row = mysqli_fetch_assoc($result)) {
							$pending_revenue = $row["SUM(order_cost)"];
						}
						mysqli_free_result($result);
					}
					echo "<div class='manager_answer'>";
					echo "<p>Estimated total revenue: $", number_format($total_revenue,0,".",","), "</p>";
					echo "<p>Current revenue: $", number_format($real_revenue,0,".",","), "</p>";
					echo "<p>Pending: $", number_format($pending_revenue,0,".",","), "</p>";
					echo "</div>";
				}

				// close the database connection
				mysqli_close($conn);
			}
		?>
	</main>


	
  <!-- The footer -->
  <?php
	include "footer.inc";
	?>
</body>
