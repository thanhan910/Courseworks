/* Filename: part2.js
Target html: enquire.html
Purpose : check the form inputs
Author: Thanh An Nguyen - 103125896
Date written: April 22nd, 2021
*/

// prevent the use of global variables
"use strict";

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

// validate pattern of input
function validate_pattern(input, input_name, RegEx, RegEx_characters) {
	var ErrMsg = "";
	if(!String(input).match(RegEx)) {
		ErrMsg += "- Your " + input_name + " must only contain " + RegEx_characters + " .\n";
	}
	return ErrMsg; 
}

// validate number input with an exact length
function validate_number_exactlength(input, input_name, exactlength) {
	// initialize error message, the input must be entered
	var ErrorMessage = validate_required(input, input_name, true);
	// while the data is entered
	if(ErrorMessage == "") {
		//check if the input is a number with an exact length
		if(isNaN(input) || String(input).length != exactlength) {
			ErrorMessage += "- Your " + input_name + " must be a " + exactlength + "-digit number.\n";
		}
	}
	return ErrorMessage; 
}

// the quantity must be a positive integer
// this function checks all quantity numbers, not just the product quantity
function validate_quantity(input, input_name) {
	// initialize error message, the input must be entered
	var ErrorMessage = validate_required(input, input_name, true);
	//check if the input is a positive integer
	// while the data is entered
	if(ErrorMessage == "") {
		if(isNaN(input) || input < 1) {
			ErrorMessage += "- Your " + input_name + " must be a natural number greater than 0.\n";
		}
	}
	return ErrorMessage; 
}

// validate postcode
function validate_postcode(Postcode, State) {
	// initialize error message, the input must be entered with exactly 4 digits
	var ErrorMessage = validate_number_exactlength(Postcode, "postcode", 4);
	// further validate the postcode based on the state
	// check if the postcode meet the initial condition
	if(validate_number_exactlength(Postcode, "postcode", 4) == "") {
		// put the required state codes in a map Object
		var StateCode = {
			"VIC": [3, 8], 
			"NSW": [1, 2], 
			"QLD": [4, 9], 
			"NT": [0], 
			"WA": [6], 
			"SA": [5], 
			"TAS": [7] ,
			"ACT": [0]
		};
		// select the first digit
		let digit = Number(String(Postcode)[0]);
		if (!StateCode[State].includes(digit)) {
			ErrorMessage += "- The selected state must match the first digit of the postcode:\n";
			ErrorMessage += " + VIC = 3 OR 8\n + NSW = 1 OR 2\n + QLD = 4 OR 9\n + NT = 0\n + WA = 6\n + SA=5\n + TAS=7\n + ACT= 0 \n";
			ErrorMessage += "(e.g. the postcode 3122 should match the state VIC)\n";
		}
	}
	return ErrorMessage;
}

// validate the visibility of checkboxes, based on the product the user selected.
// there are some features that the user cannot select if he/she chooses a particular product
// so this validation is used so that the users won't waste their money on unavailable features
function validateProductFeatures() {

	// get the product name
	var ChooseProduct = document.getElementById("choose-product").value;

	// here are all features that may be disappeared
	var AllFeatures = [ 
		"Storage128GB", "Storage1TB", 
		"StorageHDD", 
		"OSmacOS", "OSChromeOS" ];
	// initialize those features' checkboxes to be visible
	for(var i = 0; i < AllFeatures.length; i++) {
		var id = AllFeatures[i];
		var labelQuery = "label[for=" + id + "]";
		document.querySelector(labelQuery).style.display = "";
		document.getElementById(id).style.display = "";
		if(document.getElementById(id).checked != undefined) {
			sessionStorage.setItem(id, document.getElementById(id).checked);
		}
		
	}

	// initialize a warning variable
	var warning = false;

	if(ChooseProduct != "") {
		// there are some features that are unavailable to some product
		var NoFeatures = {
			"Apple Surface Pro X ($1,000)": [ "Storage1TB", "StorageHDD", "OSChromeOS" ],
			"IBM ThinkPad IQ 900 ($500)": [ "OSmacOS"],
			"Microsoft Macbook Air 20 ($800)": [ "Storage128GB", "OSmacOS" ],
		};

		// hide those features' checkboxes
		var NoFeaturesArray = NoFeatures[ChooseProduct]; 
		for(var i = 0; i < NoFeaturesArray.length; i++) {
			var id = NoFeaturesArray[i];
			var labelQuery = "label[for=" + id + "]";
			document.querySelector(labelQuery).style.display = "none";
			document.getElementById(id).style.display = "none";
			if(document.getElementById(id).checked == true) {
				warning = true;
				document.getElementById(id).checked = false;
				sessionStorage.setItem(id, document.getElementById(id).checked);
			}
			else if(document.getElementById(id).checked == false) {
				sessionStorage.setItem(id, document.getElementById(id).checked);
			}
		}
	}

	// product names
	var Product = {
		"Apple Surface Pro X ($1,000)": "Apple Surface Pro X",
		"IBM ThinkPad IQ 900 ($500)": "IBM ThinkPad IQ 900",
		"Microsoft Macbook Air 20 ($800)": "Microsoft Macbook Air 20"
	};
	//warn if the user chooses an unavailable feature
	if(warning) {
		alert("Some features may not be available for " + Product[ChooseProduct] + ".\nWe have disabled those unavailable features in the form." + "\nPlease check the features carefully before submitting the form.");
	}
}

// validate the inputs (notice that there is no TotalPrice or CostPerLaptop)
function validate_enquiry_form(
	FirstName, 
	LastName,
	State,
	Postcode,
	PhoneNumber, 
	Quantity) {

	// initialize error message
	var ErrorMessage = "";
	// first name
	ErrorMessage += validate_pattern(FirstName, "first name", /^[a-zA-Z]+$/, "alpha characters");
	// last name
	ErrorMessage += validate_pattern(LastName, "last name", /^[a-zA-Z\-]+$/, "alpha characters or hyphens");
	// postcode
	ErrorMessage += validate_postcode(Postcode, State);
	// phone number
	ErrorMessage += validate_number_exactlength(PhoneNumber, "phone number", 10);
	// number of products
	ErrorMessage += validate_quantity(Quantity, "number of laptops", true);

	return ErrorMessage;
}

// calculate cost
function calculateCostPerLaptop(ChooseProduct) {
	// Calculating the price
	// I use map instead of switch case for convenience
	// create a new object: { key1: "value1", key2: "value2" } 
	// (these are objects not maps, but I use them for map similarities)
	// laptop object 
	var LaptopObject = 
	{"Apple Surface Pro X ($1,000)": 1000, 
	"IBM ThinkPad IQ 900 ($500)": 500, 
	"Microsoft Macbook Air 20 ($800)": 800 };
	// calculate the laptop cost
	var LaptopCost = LaptopObject[ChooseProduct];
	// denote the features array
	var FeaturesArray = [ 
		"RAM8GB", "RAM16GB", "RAM32GB", 
		"Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB", 
		"StorageHDD", "StorageSSD",
		"OSLinux", "OSmacOS", "OSWindows", "OSChromeOS"
	];
	// add features costs
	var FeaturesMap = { 
		"RAM8GB": 10, "RAM16GB": 20, "RAM32GB": 30, 
		"Storage128GB": 100, "Storage256GB": 150, "Storage512GB": 200, "Storage1TB": 250, 
		"StorageHDD": 50, "StorageSSD": 100,
		"OSLinux": 0, "OSmacOS": 20, "OSWindows": 10, "OSChromeOS": 5
	};
	var FeatureCost = 0;
	for(var i = 0; i < FeaturesArray.length; i++) {
		var id = FeaturesArray[i];
		if(document.getElementById(id).checked) FeatureCost += FeaturesMap[id];  
	}
	// calculate cost per laptop
	return (LaptopCost + FeatureCost);
}

// store all inputs
function storecustomerinfo() {

	// each id will have a specific key name for its sessionStorage
	var keyid = {
		"first-name": "FirstName", 
		"last-name": "LastName", 
		"email-address": "EmailAddress",
		"street-address": "StreetAddress",
		"suburb-town": "SuburbTown",
		"state": "State",
		"postcode": "Postcode",
		"phone-number": "PhoneNumber",
		"preferred-contact": "PreferredContact",
		"choose-product": "ChooseProduct",
		"quantity": "Quantity",
		"memory": "Memory",
		"storage": "Storage", 
		"storage-device": "StorageDevice",
		"OS": "OS",
		"write-more": "WriteMore",
		"preferemail": "preferemail", 
		"preferpost": "preferpost", 
		"preferphone": "preferphone",
		"RAM8GB": "RAM8GB", 
		"RAM16GB": "RAM16GB", 
		"RAM32GB" : "RAM32GB", 
		"Storage128GB" : "Storage128GB", 
		"Storage256GB" : "Storage256GB", 
		"Storage512GB" : "Storage512GB", 
		"Storage1TB": "Storage1TB", 
		"StorageHDD":"StorageHDD", 
		"StorageSSD": "StorageSSD",
		"OSLinux":"OSLinux", 
		"OSmacOS": "OSmacOS", 
		"OSWindows":"OSWindows", 
		"OSChromeOS":"OSChromeOS" 
	};

	// store the inputs that have values
	// create an array of their ids
	var idValue = [
	"first-name", 
	"last-name", 
	"email-address",
	"street-address",
	"suburb-town",
	"state",
	"postcode",
	"phone-number",
	"preferred-contact",
	"choose-product",
	"quantity",
	"write-more", 
	];
	//store the inputs
	for(var i = 0; i < idValue.length; i++) {
		var id = idValue[i];
		var key = keyid[id];
		sessionStorage.setItem(key, document.getElementById(id).value);
	}

	// lets call a set of checkboxes that have the same "name" attribute as a "checkboxes class"
	// store the checkboxes classes
	// create an array of checkboxes classes' ids
	var idCheckBoxes = [
		"preferred-contact",
		"memory",
		"storage", 
		"storage-device",
		"OS" 
	];
	// create an array of checkboxes in each checkboxes classes 
	var idCheckBoxesArray = {
		"preferred-contact": ["preferemail", "preferpost", "preferphone"],
		"memory": ["RAM8GB", "RAM16GB", "RAM32GB"],
		"storage": ["Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB"], 
		"storage-device": ["StorageHDD", "StorageSSD"],
		"OS": ["OSLinux", "OSmacOS", "OSWindows", "OSChromeOS"] 
	};
	// iterate through every checkboxes class
	for(var i = 0; i < idCheckBoxes.length; i++) {
		var name_id = idCheckBoxes[i];
		var name_list = idCheckBoxesArray[name_id];
		var name_Array = [];
		for(var j = 0; j < name_list.length; j++) {
			var id = name_list[j];
			var key = keyid[id];
			var checkid = document.getElementById(id).checked;
			sessionStorage.setItem(key, checkid);
			if(checkid) {
			   var valueid = document.getElementById(id).value;
				name_Array.push(valueid);
			}
		}
		var name_key = keyid[name_id];
		sessionStorage.setItem(name_key, name_Array.join(", "));
	}
}

// main function for enquiry form onsubmit
function enquiry_form() {
	// get all values
	var FirstName = document.getElementById("first-name").value;
	var LastName = document.getElementById("last-name").value;
	var State = document.getElementById("state").value;
	var Postcode = document.getElementById("postcode").value;
	var PhoneNumber = document.getElementById("phone-number").value;
  var ChooseProduct = document.getElementById("choose-product").value;
	var Quantity = document.getElementById("quantity").value;

	// validate data entered
	var ErrorMessage = validate_enquiry_form(
		FirstName, 
		LastName,
		State,
		Postcode,
		PhoneNumber, 
		Quantity);
	// When an user chooses a laptop, some features will be unavailable
	// this ensures that the unavailable features will not be counted in the total cost
	validateProductFeatures();
	// the returned boolean valid value
	// form can only be submitted if valid = true
	var valid = true;
	//alert error message
	if(ErrorMessage != "") {
		ErrorMessage = "Sorry, there are a few things you need to fix before you submit the form:\n" + ErrorMessage;
		alert(ErrorMessage);
		valid = false;
	}

	// calculate and store the price
	var CostPerLaptop = calculateCostPerLaptop(ChooseProduct);
	var TotalPrice = Quantity * CostPerLaptop;
	sessionStorage.CostPerLaptop = CostPerLaptop;
	sessionStorage.TotalPrice = TotalPrice;
	// store the checkboxes and radios in sessionStorage, after validate 
	storecustomerinfo();

	// if not valid the form will not send the data
	return valid;
}

// prefill form
function prefill_form() {

	// each id will have a specific sessionStorage key name
	var keyValue = {
		"first-name": "FirstName", 
		"last-name": "LastName", 
		"email-address": "EmailAddress",
		"street-address": "StreetAddress",
		"suburb-town": "SuburbTown",
		"state": "State",
		"postcode": "Postcode",
		"phone-number": "PhoneNumber",
		"preferred-contact": "PreferredContact",
		"choose-product": "ChooseProduct",
		"quantity": "Quantity",
		"memory": "Memory",
		"storage": "Storage", 
		"storage-device": "StorageDevice",
		"OS": "OS",
		"write-more": "WriteMore"
	};

	// store the inputs that have values
	var idValue = [
		"first-name", 
		"last-name", 
		"email-address",
		"street-address",
		"suburb-town",
		"state",
		"postcode",
		"phone-number",
		"preferred-contact",
		"choose-product",
		"quantity",
		"write-more", 
	];
	for(var i = 0; i < idValue.length; i++) {
		var id = idValue[i];
		var key = keyValue[id];
		if(sessionStorage.getItem(key) != undefined) {
			document.getElementById(id).value = sessionStorage.getItem(key);
		}
	}
}

function prefill_checkboxes() {
	// prefill the checkboxes and radios
	var idcheckbox = [ "preferemail", "preferpost", "preferphone",
		"RAM8GB", "RAM16GB", "RAM32GB", 
		"Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB", 
		"StorageHDD", "StorageSSD",
		"OSLinux", "OSmacOS", "OSWindows", "OSChromeOS" 
	];
	for(var i = 0; i < idcheckbox.length; i++) {
		var id = idcheckbox[i];
		var key = id;
		if(sessionStorage.getItem(key) != undefined) {
			// for some reason when I use the below the document.getElementById(id).checked always become true
			// document.getElementById(id).checked = sessionStorage.getItem(key);
			if(sessionStorage.getItem(key) == true) {
				document.getElementById(id).checked = true;
			}
			else if(sessionStorage.getItem(key) == false) {
				document.getElementById(id).checked = false;
			}
		}
	}
}


// display product image
function display_product_image() {
	var ChooseProduct = document.getElementById("choose-product").value;
	switch(ChooseProduct) {
		case "Apple Surface Pro X ($1,000)":
			document.getElementById("enquire-product-figure").style.display = "";
			document.getElementById("enquire-product-img").src = "images/applelaptop.jpg";
			document.getElementById("enquire-product-figcaption").textContent = "Apple Surface Pro X";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			document.getElementById("enquire-product-figure").style.display = "";
			document.getElementById("enquire-product-img").src = "images/ibmlaptop.jpg";
			document.getElementById("enquire-product-figcaption").textContent = "IBM ThinkPad IQ 900";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			document.getElementById("enquire-product-figure").style.display = "";
			document.getElementById("enquire-product-img").src = "images/microsoftlaptop.jpg";
			document.getElementById("enquire-product-figcaption").textContent = "Microsoft Macbook Air 20";
			break;
		default:
			document.getElementById("enquire-product-figure").style.display = "none";
	}
}

// when the user chooses a product, validate the features and display the product image
function choosing_product() {
	display_product_image();
	validateProductFeatures();
}

// main function
function init() {
	// prefill form
	prefill_form();
	// prefill checkboxes
	prefill_checkboxes();
	// display the image
	display_product_image();
	// validate the features. Some features that are unavailable for the product will be hidden
	validateProductFeatures();
	// dynamically validate the features when the user choose the product
	document.getElementById("choose-product").onchange = choosing_product;
	// validate the form and store the data after click submit
	document.getElementById("product-enquiry").onsubmit = enquiry_form;
}

window.onload = init;