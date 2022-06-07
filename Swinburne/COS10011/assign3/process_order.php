<!-- I separate this php file into sections of <?php ?> so that the code is easier to see -->
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
	if (!isset($_SESSION["in_payment_php"]) and !isset($_SESSION["in_fix_order_php"])) {
		unset($_SESSION["in_payment_php"]);
		unset($_SESSION["in_fix_order_php"]);
		header("location:enquire.php");
	}
	else {
		unset($_SESSION["in_payment_php"]);
		unset($_SESSION["in_fix_order_php"]);
		$_SESSION["in_process_order_php"] = true;
	}
?>
<?php
	// some functions
	function validate(
		$first_name,
		$last_name,
		$email_address,
		$street_address,
		$suburb_town,
		$state,
		$postcode,
		$phone_number,
		$preferred_contact,
		$choose_product,
		$memory,
		$storage,
		$storage_device,
		$OS, 
		$write_more,
		$quantity,
		$credit_card_type,
		$credit_card_name,
		$credit_card_number,
		$credit_card_expiry_date,
		$credit_card_verification_value
	) {
		$fix_first_name = "";
		$fix_last_name = "";
		$fix_email_address = "";
		$fix_street_address = "";
		$fix_suburb_town = "";
		$fix_state = "";
		$fix_postcode = "";
		$fix_phone_number = "";
		$fix_preferred_contact = "";
		$fix_choose_product = "";
		$fix_memory = "";
		$fix_storage = "";
		$fix_storage_device = "";
		$fix_OS = "";
		$fix_write_more = "";
		$fix_quantity = "";
		$fix_credit_card_type = "";
		$fix_credit_card_name = "";
		$fix_credit_card_number = "";
		$fix_credit_card_expiry_date = "";
		$fix_credit_card_verification_value = "";
		// validate inputs
		// first name
		if($first_name == "") {
			$fix_first_name .= "Please enter your first name.\n";
		}
		else if(strlen($first_name) > 25) {
			$fix_first_name .= "Your first name must have no more than 25 characters.\n";
		}
		else if(!preg_match('/^[a-zA-Z]+$/', $first_name)) {
			$fix_first_name .= "Your first name must only contain alpha characters.\n";
		}
		// last name
		if($last_name == "") {
			$fix_last_name .= "Please enter your last name.\n";
		}
		else if(strlen($last_name) > 25) {
			$fix_last_name .= "Your last name must have no more than 25 characters.\n";
		}
		else if(!preg_match('/^[a-zA-Z\-]+$/', $last_name)) {
			$fix_last_name .= "Your last name must only contain alpha characters or hyphens.\n";
		}
		// email address
		if($email_address == "") {
			$fix_email_address .= "Please enter your email address.\n";
		}
		else if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
			// reference: https://www.w3schools.com/php/php_form_url_email.asp
		  $fix_email_address .= "Your email address should have a valid email format.\n";
		}
		// street address
		if($street_address == "") {
			$fix_street_address .= "Please enter your street address.\n";
		}
		else if(strlen($street_address) > 40) {
			$fix_street_address .= "Your street address must have no more than 40 characters.\n";
		}
		// suburb town
		if($suburb_town == "") {
			$fix_suburb_town .= "Please enter your suburb or town address.\n";
		}
		else if(strlen($suburb_town) > 20) {
			$fix_suburb_town .= "Your suburb or town address must have no more than 20 characters.\n";
		}
		// state
		if($state == "") {
			$fix_state .= "Please choose your state.\n";
		}
		// postcode
		if($postcode == "") {
			$fix_postcode .= "Please enter your postcode.\n";
		}
		else if(!is_numeric($postcode)) {
			$fix_postcode .= "Your postcode must be a 4-digit number.\n";
		}
		else if(strlen(strval($postcode)) != 4) {
			$fix_postcode .= "Your postcode must be a 4-digit number.\n";
		}
		else if($state != "") {
			$state_array = array(
				"VIC" => array(3, 8), 
				"NSW" => array(1, 2), 
				"QLD" => array(4, 9), 
				"NT" => array(0), 
				"WA" => array(6), 
				"SA" => array(5), 
				"TAS" => array(7),
				"ACT" => array(0)
			);
			if(!in_array($postcode[0], $state_array[$state])) {
				$fix_postcode .= "The selected state must match the first digit of the postcode:\n";
				$fix_postcode .= "VIC = 3 OR 8\n";
				$fix_postcode .= "NSW = 1 OR 2\n";
				$fix_postcode .= "QLD = 4 OR 9\n";
				$fix_postcode .= "NT = 0\n";
				$fix_postcode .= "WA = 6\n";
				$fix_postcode .= "SA=5\n";
				$fix_postcode .= "TAS=7\n";
				$fix_postcode .= "ACT= 0\n";
				$fix_postcode .= "(e.g. the postcode 3122 should match the state VIC)\n";
			}
		}
		// phone number
		if($phone_number == "") {
			$fix_phone_number .= "Please enter your phone number.\n";
		}
		else if(!is_numeric($phone_number)) {
			$fix_phone_number .= "Your phone number must be a 10-digit number.\n";
		}
		else if(strlen(strval($phone_number)) != 10) {
			$fix_phone_number .= "Your phone number must be a 10-digit number.\n";
		}
		// preferred contact
		if($preferred_contact == "") {
			$fix_preferred_contact .= "Please choose your preferred contact method.\n";
		}
		// choose product
		if($choose_product == "") {
			$fix_choose_product .= "Please choose your product.\n";
		}
		else {
			// features
			switch ($choose_product) {
				case "Apple Surface Pro X ($1,000)":
					if(strpos($storage, "1TB") !== false) {
						$fix_storage .= "A 1TB storage is not available for the Apple Surface Pro X.\n";
					}
					if(strpos($storage_device, "HDD") !== false) {
						$fix_storage_device .= "HDD is not available for the Apple Surface Pro X.\n";
					}
					if(strpos($OS, "ChromeOS") !== false) {
						$fix_OS .= "ChromeOS is not available for the Apple Surface Pro X.\n";
					}
					break;
				case "IBM ThinkPad IQ 900 ($500)":
					if(strpos($OS, "macOS") !== false) {
						$fix_OS .= "macOS is not available for the IBM ThinkPad IQ 900.\n";
					}
					break;
				case "Microsoft Macbook Air 20 ($800)":
					if(strpos($storage, "128GB") !== false) {
						$fix_storage .= "Just 128GB storage is not available for the Microsoft Macbook Air 20.\n";
					}
					if(strpos($OS, "macOS") !== false) {
						$fix_OS .= "macOS is not available for the Microsoft Macbook Air 20.\n";
					}
					break;
			}
		}
		// write more // no need
		// quantity
		if($quantity == "") {
			$fix_quantity .= "Please enter the number of products you want to buy.\n";
		}
		if(!is_numeric($quantity)) {
			$fix_quantity .= "Number of products must be a number.\n";
		}
		// credit card name
		if($credit_card_name == "") {
			$fix_credit_card_name .= "Please enter your name on your credit card.\n";
		}
		// credit card type
		if($credit_card_type == "") {
			$fix_credit_card_type .= "Please choose your credit card type.\n";
		}
		// credit card number
		if($credit_card_number == "") {
			$fix_credit_card_number .= "Please enter your card number.\n";
		}
		else if(!is_numeric($credit_card_number)) {
			$fix_credit_card_number .= "Your card number must be a number.\n";
		}
		else {
			switch($credit_card_type) {
				case "Visa":
					if(strlen(strval($credit_card_number)) != 16) {
						$fix_credit_card_number .= "A Visa card number must have 16 digits.\n";
						$fix_credit_card_number .= "A Mastercard number must have 16 digits.\n";
						$fix_credit_card_number .= "An American Express card number must have 15 digits.\n";
					}
					else if((int)$credit_card_number[0] != 4) {
						$fix_credit_card_number .= "A Visa card number must start with 4.\n";
						$fix_credit_card_number .= "A Mastercard number must start with digits 51 through to 55.\n";
						$fix_credit_card_number .= "An American Express card number must start with 34 or 37.\n";
					}
					break;
				case "Mastercard":
					if(strlen(strval($credit_card_number)) != 16) {
						$fix_credit_card_number .= "A Visa card number must have 16 digits.\n";
						$fix_credit_card_number .= "A Mastercard number must have 16 digits.\n";
						$fix_credit_card_number .= "An American Express card number must have 15 digits.\n";
					}
					else if((int)substr($credit_card_number, 0, 2) < 51 
						|| (int)substr($credit_card_number, 0, 2) > 55) {
						$fix_credit_card_number .= "A Visa card number must start with 4.\n";
						$fix_credit_card_number .= "A Mastercard number must start with digits 51 through to 55.\n";
						$fix_credit_card_number .= "An American Express card number must start with 34 or 37.\n";
					}
					break;
				case "American Express":
					if(strlen(strval($credit_card_number)) != 15) {
						$fix_credit_card_number .= "A Visa card number must have 16 digits.\n";
						$fix_credit_card_number .= "A Mastercard number must have 16 digits.\n";
						$fix_credit_card_number .= "An American Express card number must have 15 digits.\n";
					}
					else if((int)substr($credit_card_number, 0, 2) != 34 
						and (int)substr($credit_card_number, 0, 2) != 37) {
						$fix_credit_card_number .= "A Visa card number must start with 4.\n";
						$fix_credit_card_number .= "A Mastercard number must start with digits 51 through to 55.\n";
						$fix_credit_card_number .= "An American Express card number must start with 34 or 37.\n";
					}
					break;
			}
			
		}
		// credit card expiry date
		if($credit_card_expiry_date == "") {
			$fix_credit_card_expiry_date .= "Please enter your credit card expiry date.\n";
		}
		else if(!preg_match('/^(0[1-9]|1[0-2])\-([0-9]{2})$/', $credit_card_expiry_date)) {
			$fix_credit_card_expiry_date .= "Your credit card expiry date should have the format mm-yy.\n";
		}
		// credit card verification value
		echo $credit_card_verification_value == "";
		if($credit_card_verification_value == "") {
			$fix_credit_card_verification_value .= "Please enter your credit card verification value.\n";
			echo $fix_credit_card_verification_value;
		}
		// return value

		$fix_array = array(
			"fix_first_name",
			"fix_last_name",
			"fix_email_address",
			"fix_street_address",
			"fix_suburb_town",
			"fix_state",
			"fix_postcode",
			"fix_phone_number",
			"fix_preferred_contact",
			"fix_choose_product",
			"fix_memory",
			"fix_storage",
			"fix_storage_device",
			"fix_OS",
			"fix_write_more",
			"fix_quantity",
			"fix_credit_card_type",
			"fix_credit_card_name",
			"fix_credit_card_number",
			"fix_credit_card_expiry_date",
			"fix_credit_card_verification_value"
		);
		$valid = true;
		$fix_array_length = count($fix_array);
		for($i = 0; $i < $fix_array_length; $i++) {
			$fix_id = $fix_array[$i];
			$_SESSION[$fix_id] = $$fix_id;
			// // debug
			// echo "<p>Fix: ", $fix_id, " : ", $$fix_id,"</p>";
			if($$fix_id != "") $valid = false;
		}
		return $valid;

	}

	function store_inputs(
		$first_name,
		$last_name,
		$email_address,
		$street_address,
		$suburb_town,
		$state,
		$postcode,
		$phone_number,
		$preferred_contact,
		$choose_product,
		$memory,
		$storage,
		$storage_device,
		$OS, 
		$write_more,
		$quantity,
		$credit_card_type,
		$credit_card_name,
		$credit_card_number,
		$credit_card_expiry_date,
		$credit_card_verification_value
	) {
		$idarray = array(
			"first_name",
			"last_name",
			"email_address",
			"street_address",
			"suburb_town",
			"state",
			"postcode",
			"phone_number",
			"preferred_contact",
			"choose_product",
			"memory",
			"storage",
			"storage_device",
			"OS",
			"write_more",
			"quantity",
			"credit_card_type",
			"credit_card_name",
			"credit_card_number",
			"credit_card_expiry_date",
			"credit_card_verification_value"
		);

		$idarray_length = count($idarray);

		for($i = 0; $i < $idarray_length; $i++) {
			$id = $idarray[$i];
			$_SESSION[$id] = $$id; 
		}
	}

	function calculate_cost(
		$choose_product,
		$memory,
		$storage,
		$storage_device,
		$OS
	) {
		$cost_per_laptop = 0;
		// product price
		switch($choose_product) {
			case "Apple Surface Pro X ($1,000)": 
				$cost_per_laptop += 1000;
				break;
			case "IBM ThinkPad IQ 900 ($500)":
				$cost_per_laptop += 500;
				break;
			case "Microsoft Macbook Air 20 ($800)":
				$cost_per_laptop += 800;
				break;
		}
		// memory
		if(strpos($memory, "8GB") !== false) {
			$cost_per_laptop += 10;
		}
		if(strpos($memory, "16GB") !== false) {
			$cost_per_laptop += 20;
		}
		if(strpos($memory, "32GB") !== false) {
			$cost_per_laptop += 30;
		}
		// storage
		if(strpos($storage, "128GB") !== false and $choose_product != "Microsoft Macbook Air 20 ($800)") {
			$cost_per_laptop += 100;
		}
		if(strpos($storage, "256GB") !== false) {
			$cost_per_laptop += 150;
		}
		if(strpos($storage, "512GB") !== false) {
			$cost_per_laptop += 200;
		}
		if(strpos($storage, "1TB") !== false and $choose_product != "Apple Surface Pro X ($1,000)") {
			$cost_per_laptop += 250;
		}
		// storage device
		if(strpos($storage_device, "HDD") !== false and $choose_product != "Apple Surface Pro X ($1,000)") {
			$cost_per_laptop += 50;
		}
		if(strpos($storage_device, "SSD") !== false) {
			$cost_per_laptop += 100;
		}
		// OS
		if(strpos($OS, "Linux") !== false) {
			$cost_per_laptop += 0;
		}
		if(strpos($OS, "Windows") !== false) {
			$cost_per_laptop += 10;
		}
		if(strpos($OS, "macOS") !== false and $choose_product == "Apple Surface Pro X ($1,000)") {
			$cost_per_laptop += 20;
		}
		if(strpos($OS, "ChromeOS") !== false and $choose_product != "Apple Surface Pro X ($1,000)") {
			$cost_per_laptop += 5;
		}
		// return cost per laptop
		if($choose_product == "") return 0;
		else return $cost_per_laptop;
	}
?>
<?php
	// connection info
	require_once("settings.php");
	$conn = @mysqli_connect($host,
		$user,
		$pwd,
		$sql_db
	);

	// Checks if connection is successful
	if(!$conn) {
		echo "<p>Database connection failure</p>";
	}

	// Upon successful connection
	else {

		$sql_table = "orders";

		$idarray = array(
			"first_name",
			"last_name",
			"email_address",
			"street_address",
			"suburb_town",
			"state",
			"postcode",
			"phone_number",
			"preferred_contact",
			"choose_product",
			"memory",
			"storage",
			"storage_device",
			"OS",
			"write_more",
			"quantity",
			"credit_card_type",
			"credit_card_name",
			"credit_card_number",
			"credit_card_expiry_date",
			"credit_card_verification_value"
		);

		$idarray_length = count($idarray);

		for($i = 0; $i < $idarray_length; $i++) {
			$id = $idarray[$i];
			if(isset($_POST[$id])) {
				if($id == "write_more") {
					$write_more = htmlspecialchars(stripslashes($_POST["write_more"])); // no trim
				}
				else {
					$$id = htmlspecialchars(stripslashes(trim($_POST[$id])));
				}
				// // debug
				// echo "<p>Added ", $id, " : ", $$id, "</p>"; 
			}
			// if any data has not entered
			else {
				$$id = "";
				// header("location:payment.php");
			}
		}

		// store inputs
		store_inputs(
			$first_name,
			$last_name,
			$email_address,
			$street_address,
			$suburb_town,
			$state,
			$postcode,
			$phone_number,
			$preferred_contact,
			$choose_product,
			$memory,
			$storage,
			$storage_device,
			$OS, 
			$write_more,
			$quantity,
			$credit_card_type,
			$credit_card_name,
			$credit_card_number,
			$credit_card_expiry_date,
			$credit_card_verification_value
		);

		// validate the inputs
		$valid = validate(
			$first_name,
			$last_name,
			$email_address,
			$street_address,
			$suburb_town,
			$state,
			$postcode,
			$phone_number,
			$preferred_contact,
			$choose_product,
			$memory,
			$storage,
			$storage_device,
			$OS,
			$write_more,
			$quantity,
			$credit_card_type,
			$credit_card_name,
			$credit_card_number,
			$credit_card_expiry_date,
			$credit_card_verification_value
		);

		if(!$valid) {
			// // debug
			// echo '<a href="fix_order.php">Go here to fix</a>';
			header("location:fix_order.php");
		}
		else {

			// calculate cost
			$cost_per_laptop = calculate_cost(
				$choose_product,
				$memory,
				$storage,
				$storage_device,
				$OS
			);
			// store some main order values
			$_SESSION["quantity"] = $quantity;
			$_SESSION["cost_per_laptop"] = $cost_per_laptop;
			$order_cost = $quantity * $cost_per_laptop;
			$_SESSION["order_cost"] = $order_cost;
			$order_time = time();
			$_SESSION["order_time"] = $order_time;
			$order_status = "PENDING";
			$_SESSION["order_status"] = $order_status;

			// Set up the SQL command to query

			$query_create_table = "CREATE TABLE IF NOT EXISTS $sql_table (
			  order_id INT AUTO_INCREMENT PRIMARY KEY,
			  order_time INT,
				order_status TEXT,
				order_cost INT,
				first_name VARCHAR(25), 
				last_name VARCHAR(25), 
				email_address TEXT,
				street_address VARCHAR(40),
				suburb_town VARCHAR(20),
				state VARCHAR(3),
				postcode VARCHAR(4),
				phone_number VARCHAR(10),
				preferred_contact TEXT,
				choose_product TEXT,
				memory TEXT,
				storage TEXT,
				storage_device TEXT,
				OS TEXT,
				write_more TEXT,
				cost_per_laptop INT,
				quantity INT,
				credit_card_type TEXT,
				credit_card_name VARCHAR(40),
				credit_card_number VARCHAR(16),
				credit_card_expiry_date VARCHAR(5),
				credit_card_verification_value TEXT
			);";

			$result_create_table = mysqli_query($conn, $query_create_table);

			if(!$result_create_table) {
				echo "<p class=\"wrong\" >Something is wrong with ", $query, "</p>";
			}
			else {
				// Display an operation successful message
				echo "<p class=\"ok\" >Successfully created a new table</p>";
			} // if create new table successful

			$query = "INSERT INTO $sql_table(
				order_time,
				order_status,
				order_cost,
				first_name, 
				last_name, 
				email_address,
				street_address,
				suburb_town,
				state,
				postcode,
				phone_number,
				preferred_contact,
				choose_product,
				memory,
				storage,
				storage_device,
				OS,
				write_more,
				cost_per_laptop,
				quantity,
				credit_card_type,
				credit_card_name,
				credit_card_number,
				credit_card_expiry_date,
				credit_card_verification_value
			) VALUES (
				'$order_time',
				'$order_status',
				'$order_cost',
				'$first_name', 
				'$last_name', 
				'$email_address',
				'$street_address',
				'$suburb_town',
				'$state',
				'$postcode',
				'$phone_number',
				'$preferred_contact',
				'$choose_product',
				'$memory',
				'$storage',
				'$storage_device',
				'$OS',
				'$write_more',
				'$cost_per_laptop',
				'$quantity',
				'$credit_card_type',
				'$credit_card_name',
				'$credit_card_number',
				'$credit_card_expiry_date',
				'$credit_card_verification_value'
			);";

			// execute the query and store result into the result pointer
			$result = mysqli_query($conn, $query);

			// check to see if the databases exist first.
			// checks if the execution was successful
			if(!$result) {
				echo "<p class=\"wrong\" >Something is wrong with ", $query, "</p>";


				// would not show in a production script
			}
			else {
				// Display an operation successful message
				echo "<p class=\"ok\" >Successfully added a new record</p>";
				$order_id = $conn->insert_id;
				$_SESSION["order_id"] = $order_id;
				// // debug
				// echo "<a href='receipt.php'>receipt.php</a>";
				header("location:receipt.php");
			} // if successful query operation



		} // if all inputs are valid
			

		// close the database connection
		mysqli_close($conn);
	} // if successful database connection
?>
