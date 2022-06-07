/* Filename: part2.js
Target html: enquire.html
Purpose : check the form inputs
Author: Thanh An Nguyen - 103125896
Date written: April 22nd, 2021
*/

// prevent the use of global variables
"use strict";

// function to add decimal separators every three digit
// Reference: https://stackoverflow.com/questions/2901102/how-to-print-a-number-with-commas-as-thousands-separators-in-javascript
function addDecimalSeparator(number) {
	return String(number).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function write_customer_info() {
	// write customer information into the form
	var PaymentID = [
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
		"cost_per_laptop",
		"quantity"
	];
	for(var i = 0; i < PaymentID.length; i++) {
		var id = PaymentID[i];
		var payment_id = "payment_" + id;
		// checks if the element with the id exist, in case we replace JS with PHP
		if(document.getElementById(payment_id)) {
			if(sessionStorage.getItem(id) != "" && sessionStorage.getItem(id) != undefined) {
				document.getElementById(payment_id).textContent = sessionStorage.getItem(id);
			}
		}
	}
	// costs per laptop. Add decimal separator into the number
	document.getElementById("payment_cost_per_laptop").textContent = addDecimalSeparator(cost_per_laptop);
	// there is a second "Number of laptop: so that customer can check the product quantity before paying
	if(document.getElementById("payment_quantity_2")) {
		if(sessionStorage.getItem("quantity") != "" && sessionStorage.getItem("quantity") != undefined) {
			document.getElementById("payment_quantity_2").textContent = sessionStorage.quantity;
		}
	}
	// // total price. Add decimal separator into the number
	// var order_cost = sessionStorage.order_cost;
	// document.getElementById("payment_order_cost").textContent = addDecimalSeparator(order_cost);
	// prefill the proposed fullname of customer in the credit card name input
	var full_name = sessionStorage.first_name + " " + sessionStorage.last_name;
	document.getElementById("credit_card_name").value = full_name;
}

// store the inputs in the form
function store_hidden_input() {
	// put all data into the hidden inputs
	var AllID = [
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
		"cost_per_laptop",
		"quantity",
		"order_cost"
	];
	for(var i = 0; i < AllID.length; i++) {
		var id = AllID[i];
		document.getElementById(id).value = sessionStorage.getItem(id);
		// if(sessionStorage.getItem(id) != "" && sessionStorage.getItem(id) != undefined) {
		// 	document.getElementById(id).value = sessionStorage.getItem(id);
		// }
		// else {
		// 	document.getElementById(id).value = "";
		// }
	}
}

// store credit card information in sessionstorage
function storecreditcard(
	credit_card_type,
	credit_card_name,
	credit_card_number,
	credit_card_expiry_date,
	credit_card_verification_value
	) {
	sessionStorage.credit_card_type = credit_card_type;
	sessionStorage.credit_card_name = credit_card_name;
	sessionStorage.credit_card_number = credit_card_number;
	sessionStorage.credit_card_expiry_date = credit_card_expiry_date;
	sessionStorage.credit_card_verification_value = credit_card_verification_value;
}

// validate the credit card information
function validateCreditCard(
	credit_card_type,
	credit_card_name,
	credit_card_number,
	credit_card_expiry_date,
	credit_card_verification_value
	) {
	// initialize error message
	var ErrorMessage = "";
	
	// credit card type "required" will be checked by the browser

	// check credit card name
	if(String(credit_card_name).length > 40) {
			ErrorMessage += "- Your credit card name must not have more than 40 characters.\n";
	}
	if(!String(credit_card_name).match(/^[a-zA-Z\s]+$/)) {
		ErrorMessage += "- Your credit card name must only contain alphabet characters and spaces .\n";
	}
	
	// check credit card number
	switch(credit_card_type) {
		case "Visa":
			var ErrMsg = "";
			if(isNaN(credit_card_number) || String(credit_card_number).length != 16) {
				ErrMsg += " + Your card number must be a 16-digit number.\n";
			}
			if(String(credit_card_number)[0] != "4") {
				ErrMsg += " + Your card number must start with 4.\n";
			}
			if(ErrMsg != "") {
				ErrorMessage += "- Since your card type is Visa:\n" + ErrMsg;
			}
			break;
		case "Mastercard":
			var ErrMsg = "";
			if(isNaN(credit_card_number) || String(credit_card_number).length != 16) {
				ErrMsg += " + Your card number must be a 16-digit number.\n";
			}
			// in case the card number is a number
			if(!isNaN(credit_card_number)) {
				// first 2 digits
				var First2 = String(credit_card_number)[0] + String(credit_card_number)[1];
				First2 = Number(First2);
				if(First2 < 51 || First2 > 55) {
					ErrMsg += " + Your card number must start with digits 51 through to 55.\n";
				}
			}
			if(ErrMsg != "") {
				ErrorMessage += "- Since your card type is Mastercard:\n" + ErrMsg;
			}
			break;
		case "American Express":
			var ErrMsg = "";
			if(isNaN(credit_card_number) || String(credit_card_number).length != 15) {
				ErrMsg += " + Your card number must be a 15-digit number.\n";
			}
			// in case the card number is a number
			if(!isNaN(credit_card_number)) {
				// first 2 digits
				var First2 = String(credit_card_number)[0] + String(credit_card_number)[1];
				First2 = Number(First2);
				if(First2 != 34 && First2 != 37) {
					ErrMsg += " + Your card number must start with 34 or 37.\n";
				}
			}
			if(ErrMsg != "") {
				ErrorMessage += "- Since your card type is American Express:\n" + ErrMsg;
			}
			break;
		default:
			ErrorMessage +=	"- Please select your credit card type.\n";		
	}

	// validate expiry date
	if(!String(credit_card_expiry_date).match(/^(0[1-9]|1[0-2])\-([0-9]{2})$/)) {
		ErrorMessage += "- Your card expiry date must match the format: mm-yy.\n";
	}
	
	// validate card verification value
	if(isNaN(credit_card_verification_value)) {
		ErrorMessage += "- Your card verification value must be a number.";
	}
	
	return ErrorMessage;

}

function paymentForm() {
	// get inputs
	var credit_card_type = document.getElementById("credit_card_type").value;
	var credit_card_name = document.getElementById("credit_card_name").value;
	var credit_card_number = document.getElementById("credit_card_number").value;
	var credit_card_expiry_date = document.getElementById("credit_card_expiry_date").value;
	var credit_card_verification_value = document.getElementById("credit_card_verification_value").value;

	// store values even if the values are invalid
	storecreditcard(
		credit_card_type,
		credit_card_name,
		credit_card_number,
		credit_card_expiry_date,
		credit_card_verification_value);

	// validate inputs
	var ErrorMessage = "";
	var debug = true; // disable js validation
	if(!debug) {
		ErrorMessage += validateCreditCard(
		credit_card_type,
		credit_card_name,
		credit_card_number,
		credit_card_expiry_date,
		credit_card_verification_value);
	}
	

	// the returned boolean valid value
	// form can only be submitted if valid = true
	var valid = true;
	//alert error message
	if(ErrorMessage != "") {
		ErrorMessage = "Sorry, there are a few things you need to fix before you submit the form:\n" + ErrorMessage;
		alert(ErrorMessage);
		valid = false;
	}

	return valid;

}

function display_product_image() {
	var choose_product = sessionStorage.choose_product;
	switch(choose_product) {
		case "Apple Surface Pro X ($1,000)":
			document.getElementById("payment_product_figure").style.display = "";
			document.getElementById("payment_product_img").src = "images/applelaptop.jpg";
			document.getElementById("payment_product_figcaption").textContent = "Apple Surface Pro X";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			document.getElementById("payment_product_figure").style.display = "";
			document.getElementById("payment_product_img").src = "images/ibmlaptop.jpg";
			document.getElementById("payment_product_figcaption").textContent = "IBM ThinkPad IQ 900";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			document.getElementById("payment_product_figure").style.display = "";
			document.getElementById("payment_product_img").src = "images/microsoftlaptop.jpg";
			document.getElementById("payment_product_figcaption").textContent = "Microsoft Macbook Air 20";
			break;
		default:
			document.getElementById("payment_product_figure").style.display = "none";
			document.getElementById("payment_product_img").src = "";
			document.getElementById("payment_product_figcaption").textContent = "";
	}
}

// main function
function init() {
	//display the inputs
	write_customer_info();
	//store the inputs in the hidden inputs
	store_hidden_input();	
	// display figure
	display_product_image();
	// form onsubmit
	document.getElementById("payment_form").onsubmit = paymentForm;
	// cancel Button
	document.getElementById("payment_cancelButton").onclick = cancelButton;
}

function cancelButton() {
	// location.href = "index.php";
	window.location = "index.php";
	// clear storage
	sessionStorage.clear();
}

window.onload = init;