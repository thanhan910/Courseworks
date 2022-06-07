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
	document.getElementById("payment-first-name").textContent = sessionStorage.FirstName;
	document.getElementById("payment-last-name").textContent = sessionStorage.LastName;
	document.getElementById("payment-email-address").textContent = sessionStorage.EmailAddress;
	document.getElementById("payment-street-address").textContent = sessionStorage.StreetAddress;
	document.getElementById("payment-suburb-town").textContent = sessionStorage.SuburbTown;
	document.getElementById("payment-state").textContent = sessionStorage.State;
	document.getElementById("payment-postcode").textContent = sessionStorage.Postcode;
	document.getElementById("payment-phone-number").textContent = sessionStorage.PhoneNumber;
	document.getElementById("payment-preferred-contact").textContent = sessionStorage.PreferredContact;
	document.getElementById("payment-choose-product").textContent = sessionStorage.ChooseProduct;
	document.getElementById("payment-quantity").textContent = sessionStorage.Quantity;
	// for the optional inputs, the textContent will display the word "none" if there is no value
	// memory
	if(sessionStorage.Memory != "") {
		document.getElementById("payment-memory").textContent = sessionStorage.Memory;
	}
	// storage
	if(sessionStorage.Storage != "") {
		document.getElementById("payment-storage").textContent = sessionStorage.Storage;
	}
	// storage device
	if(sessionStorage.StorageDevice != "") {
		document.getElementById("payment-storage-device").textContent =  sessionStorage.StorageDevice;
	}
	// OS
	if(sessionStorage.OS != "") {
		document.getElementById("payment-OS").textContent = sessionStorage.OS;
	}
	// write more text area
	if(sessionStorage.WriteMore != "") {
		document.getElementById("payment-write-more").textContent = sessionStorage.WriteMore;
	}
	// costs per laptop. Add decimal separator into the number
	var CostPerLaptop = sessionStorage.CostPerLaptop;
	document.getElementById("payment-cost-per-laptop").textContent = addDecimalSeparator(CostPerLaptop);
	// there is a second "Number of laptop: so that customer can check the product quantity before paying
	document.getElementById("payment-quantity-2").textContent = sessionStorage.Quantity;
	// total price. Add decimal separator into the number
	var TotalPrice = sessionStorage.TotalPrice;
	document.getElementById("payment-total-price").textContent = addDecimalSeparator(TotalPrice);
	// prefill the proposed fullname of customer in the credit card name input
	var FullName = sessionStorage.FirstName + " " + sessionStorage.LastName;
	document.getElementById("credit-card-name").value = FullName;
}

// store the inputs in the form
function store_hidden_input() {
	// put all data into the hidden inputs
	document.getElementById("first-name").value = sessionStorage.FirstName;
	document.getElementById("last-name").value = sessionStorage.LastName;
	document.getElementById("email-address").value = sessionStorage.EmailAddress;
	document.getElementById("street-address").value = sessionStorage.StreetAddress;
	document.getElementById("suburb-town").value = sessionStorage.SuburbTown;
	document.getElementById("state").value = sessionStorage.State;
	document.getElementById("postcode").value = sessionStorage.Postcode;
	document.getElementById("phone-number").value = sessionStorage.PhoneNumber;
	document.getElementById("preferred-contact").value = sessionStorage.PreferredContact;
	document.getElementById("choose-product").value = sessionStorage.ChooseProduct;
	document.getElementById("memory").value = sessionStorage.Memory;
	document.getElementById("storage").value = sessionStorage.Storage;
	document.getElementById("storage-device").value =  sessionStorage.StorageDevice;
	document.getElementById("OS").value = sessionStorage.OS;
	document.getElementById("write-more").value = sessionStorage.WriteMore;
	document.getElementById("cost-per-laptop").value = sessionStorage.CostPerLaptop;
	document.getElementById("quantity").value = sessionStorage.Quantity;
	document.getElementById("total-price").value = sessionStorage.TotalPrice;
}

// store credit card information in sessionstorage
function storecreditcard(CreditCardType,
	CreditCardName,
	CreditCardNumber,
	CreditCardExpiryDate,
	CreditCardVerificationValue) {
	sessionStorage.CreditCardType = CreditCardType;
	sessionStorage.CreditCardName = CreditCardName;
	sessionStorage.CreditCardNumber = CreditCardNumber;
	sessionStorage.CreditCardExpiryDate = CreditCardExpiryDate;
	sessionStorage.CreditCardVerificationValue = CreditCardVerificationValue;
}

// some specific functions for validation

// validate required input
function validate_required(input, input_name, required) {
	var ErrorMessage = "";
	if(String(input).length == 0 && required) {
		// the validate_required can also be used for dropdown lists
		ErrorMessage += "You must enter/choose your " + input_name + ".\n";
	}
	return ErrorMessage; 
}

// validate input with a maxlength
function validate_pattern_maxlength(input, input_name, RegEx, RegEx_characters, maxlength) {
	// initialize error message, the input must be entered
	var ErrorMessage = validate_required(input, input_name, true);
	// while the data is entered
	if(ErrorMessage == "") {
	// convert input to string to validate easier
		if(String(input).length > maxlength) {
			ErrorMessage += "- Your " + input_name + " must not have more than " + maxlength + " characters.\n";
		}
		if(!String(input).match(RegEx)) {
			ErrorMessage += "- Your " + input_name + " must only contain " + RegEx_characters + " .\n";
		}
	}
	return ErrorMessage; 
}

// validate the credit card information
function validateCreditCard(CreditCardType,
	CreditCardName,
	CreditCardNumber,
	CreditCardExpiryDate,
	CreditCardVerificationValue) {
	// initialize error message
	var ErrorMessage = "";
	
	// credit card type "required" will be checked by the browser

	// check credit card name
	ErrorMessage += validate_pattern_maxlength(CreditCardName,
		"credit card name",
		/^[a-zA-Z\s]+$/,
		"alphabet characters and spaces",
		40);
	
	// check credit card number
	switch(CreditCardType) {
		case "Visa":
			var ErrMsg = "";
			if(isNaN(CreditCardNumber) || String(CreditCardNumber).length != 16) {
				ErrMsg += " + Your card number must be a 16-digit number.\n";
			}
			if(String(CreditCardNumber)[0] != "4") {
				ErrMsg += " + Your card number must start with 4.\n";
			}
			if(ErrMsg != "") {
				ErrorMessage += "- Since your card type is Visa:\n" + ErrMsg;
			}
			break;
		case "Mastercard":
			var ErrMsg = "";
			if(isNaN(CreditCardNumber) || String(CreditCardNumber).length != 16) {
				ErrMsg += " + Your card number must be a 16-digit number.\n";
			}
			// in case the card number is a number
			if(!isNaN(CreditCardNumber)) {
				// first 2 digits
				var First2 = String(CreditCardNumber)[0] + String(CreditCardNumber)[1];
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
			if(isNaN(CreditCardNumber) || String(CreditCardNumber).length != 15) {
				ErrMsg += " + Your card number must be a 15-digit number.\n";
			}
			// in case the card number is a number
			if(!isNaN(CreditCardNumber)) {
				// first 2 digits
				var First2 = String(CreditCardNumber)[0] + String(CreditCardNumber)[1];
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
	if(!String(CreditCardExpiryDate).match(/^(0[1-9]|1[0-2])\-([0-9]{2})$/)) {
		ErrorMessage += "- Your card expiry date must match the format: mm-yy.\n";
	}
	
	// validate card verification value
	if(isNaN(CreditCardVerificationValue)) {
		ErrorMessage += "- Your card verification value must be a number.";
	}
	
	return ErrorMessage;

}

function paymentForm() {
	// get inputs
	var CreditCardType = document.getElementById("credit-card-type").value;
	var CreditCardName = document.getElementById("credit-card-name").value;
	var CreditCardNumber = document.getElementById("credit-card-number").value;
	var CreditCardExpiryDate = document.getElementById("credit-card-expiry-date").value;
	var CreditCardVerificationValue = document.getElementById("credit-card-verification-value").value;

	// store values even if the values are invalid
	storecreditcard(
		CreditCardType,
		CreditCardName,
		CreditCardNumber,
		CreditCardExpiryDate,
		CreditCardVerificationValue);

	// validate inputs
	var ErrorMessage = validateCreditCard(
		CreditCardType,
		CreditCardName,
		CreditCardNumber,
		CreditCardExpiryDate,
		CreditCardVerificationValue);

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
	var ChooseProduct = document.getElementById("choose-product").value;
	switch(ChooseProduct) {
		case "Apple Surface Pro X ($1,000)":
			document.getElementById("payment-product-figure").style.display = "";
			document.getElementById("payment-product-img").src = "images/applelaptop.jpg";
			document.getElementById("payment-product-figcaption").textContent = "Apple Surface Pro X";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			document.getElementById("payment-product-figure").style.display = "";
			document.getElementById("payment-product-img").src = "images/ibmlaptop.jpg";
			document.getElementById("payment-product-figcaption").textContent = "IBM ThinkPad IQ 900";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			document.getElementById("payment-product-figure").style.display = "";
			document.getElementById("payment-product-img").src = "images/microsoftlaptop.jpg";
			document.getElementById("payment-product-figcaption").textContent = "Microsoft Macbook Air 20";
			break;
		default:
			document.getElementById("enquire-product-figure").style.display = "none";
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
	document.getElementById("payment-form").onsubmit = paymentForm;
	// cancel Button
	document.getElementById("payment-cancelButton").onclick = cancelButton;
}

function cancelButton() {
	// location.href = "index.html";
	window.location = "index.html";
	// clear storage
	sessionStorage.clear();
}

window.onload = init;


// "first-name"
// "last-name"
// "email-address"
// "street-address"
// "suburb-town"
// "state"
// "postcode"
// "phone-number"
// "prefer-email"
// "prefer-post"
// "prefer-phone"
// "choose-product"
// "quantity"
// "enquire-features"
// "enquire-textarea"