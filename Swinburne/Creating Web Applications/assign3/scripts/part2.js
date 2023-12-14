/* Filename: part2.js
Target: enquire.php
Purpose : check the form inputs
Author: Thanh An Nguyen - 103125896
Date written: April 22nd, 2021
*/

"use strict"; // prevent the use of global variables

// some specific functions for validation

function validate_quantity(input, input_name) {
	var ErrMsg = "";
	if(isNaN(input) || input < 1) { //check if the input is a positive integer
		ErrMsg += "- Your " + input_name + " must be a natural number greater than 0.\n";
	}
	return ErrMsg; 
}

function validate_postcode(postcode, state) { // validate postcode
	var ErrMsg = ""; // first the input must be entered with exactly 4 digits
	if(isNaN(postcode) || String(postcode).length != 4) {
		ErrMsg += "- Your postcode must be a 4-digit number.\n";
	}
	if(ErrMsg == "") {
		var StateCode = {
			"VIC": [3, 8], 
			"NSW": [1, 2], 
			"QLD": [4, 9], 
			"NT": [0], 
			"WA": [6], 
			"SA": [5], 
			"TAS": [7],
			"ACT": [0]
		};
		var digit = Number(String(postcode)[0]); // select the first digit
		if (!StateCode[state].includes(digit)) {
			ErrMsg += "- The selected state must match the first digit of the postcode:\n";
			ErrMsg += " + VIC = 3 OR 8\n + NSW = 1 OR 2\n + QLD = 4 OR 9\n + NT = 0\n + WA = 6\n + SA=5\n + TAS=7\n + ACT= 0 \n";
			ErrMsg += "(e.g. the postcode 3122 should match the state VIC)\n";
		}
	}
	return ErrMsg;
}

function validate_enquiry_form( // validate normal inputs
	first_name, 
	last_name,
	state,
	postcode,
	phone_number, 
	quantity) {

	var ErrMsg = "";

	if(!String(first_name).match(/^[a-zA-Z]+$/)) {
		ErrMsg += "- Your first name must only contain alpha characters.\n";
	}
	if(!String(last_name).match(/^[a-zA-Z\-]+$/)) {
		ErrMsg += "- Your last name must only contain alpha characters or hyphens.\n";
	}
	if(isNaN(phone_number) || String(phone_number).length != 10) {
		ErrMsg += "- Your phone number must be a 10-digit number.\n";
	}
	ErrMsg += validate_postcode(postcode, state);
	ErrMsg += validate_quantity(quantity, "number of laptops", true);

	return ErrMsg;
}

function validate_product_feature_after_submit() {
	var choose_product = document.getElementById("choose_product").value;
	var ErrMsg = "";
	switch(choose_product) {
		case "Apple Surface Pro X ($1,000)":
			if(document.getElementById("Storage1TB").checked
				|| document.getElementById("StorageHDD").checked
				|| document.getElementById("OSChromeOS").checked) {
				ErrMsg += "Some features may not be available for Apple Surface Pro X";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			 	
			}
			document.getElementById("Storage1TB").checked = false;
			document.getElementById("StorageHDD").checked = false;
			document.getElementById("OSChromeOS").checked = false;
			sessionStorage.setItem("Storage1TB",false);
			sessionStorage.setItem("StorageHDD",false);
			sessionStorage.setItem("OSChromeOS",false);
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			if( document.getElementById("OSmacOS").checked) {
				ErrMsg += "Some features may not be available for IBM ThinkPad IQ 900";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			 	
			}
			document.getElementById("OSmacOS").checked = false;
			sessionStorage.setItem("OSmacOS",false);
			break;
		case "Microsoft Macbook Air 20 ($800)":
			if(document.getElementById("Storage128GB").checked
				|| document.getElementById("OSmacOS").checked) {
				ErrMsg += "Some features may not be available for Microsoft Macbook Air 20";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			 	
			}
			document.getElementById("Storage128GB").checked = false;
			document.getElementById("OSmacOS").checked = false;
			sessionStorage.setItem("Storage128GB",false);
			sessionStorage.setItem("OSmacOS",false);
			break;
	}
	return ErrMsg;
}



function hide_product_feature_if_choose_a_product() {
	var choose_product = document.getElementById("choose_product").value;
	var ErrMsg = "";
	switch(choose_product) {
		case "Apple Surface Pro X ($1,000)":
			if(document.getElementById("Storage1TB").checked
				|| document.getElementById("StorageHDD").checked
				|| document.getElementById("OSChromeOS").checked) {
				ErrMsg += "Some features may not be available for Apple Surface Pro X";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			}
			document.getElementById("Storage1TB").checked = false;
			document.querySelector('label[for="Storage1TB"]').style.display = "none";
			document.getElementById("Storage1TB").style.display = "none";
			document.getElementById("StorageHDD").checked = false;
			document.querySelector('label[for="StorageHDD"]').style.display = "none";
			document.getElementById("StorageHDD").style.display = "none";
			document.getElementById("OSChromeOS").checked = false;
			document.querySelector('label[for="OSChromeOS"]').style.display = "none";
			document.getElementById("OSChromeOS").style.display = "none";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			if( document.getElementById("OSmacOS").checked) {
				ErrMsg += "Some features may not be available for IBM ThinkPad IQ 900";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			}
			document.getElementById("OSmacOS").checked = false;
			document.querySelector('label[for="OSmacOS"]').style.display = "none";
			document.getElementById("OSmacOS").style.display = "none";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			if(document.getElementById("Storage128GB").checked == true
				|| document.getElementById("OSmacOS").checked == true) {
				ErrMsg += "Some features may not be available for Microsoft Macbook Air 20";
				ErrMsg += ".\nWe have disabled those unavailable features in the form.";
			 	ErrMsg += "\nPlease check the features carefully before submitting the form.";
			}
			document.getElementById("Storage128GB").checked = false;
			document.querySelector('label[for="Storage128GB"]').style.display = "none";
			document.getElementById("Storage128GB").style.display = "none";
			document.getElementById("OSmacOS").checked = false;
			document.querySelector('label[for="OSmacOS"]').style.display = "none";
			document.getElementById("OSmacOS").style.display = "none";
			break;
	}
	if(ErrMsg != "") {
		alert(ErrMsg);
	}
}

function display_all_checkboxes() {
	var AllFeatures = [ 
		"RAM8GB", "RAM16GB", "RAM32GB", 
		"Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB", 
		"StorageHDD", "StorageSSD",
		"OSLinux", "OSmacOS", "OSWindows", "OSChromeOS"
	];
	for(var i = 0; i < AllFeatures.length; i++) {
		var id = AllFeatures[i];
		var labelQuery = "label[for=" + id + "]";
		document.querySelector(labelQuery).style.display = "";
		document.getElementById(id).style.display = "";
	}
}

// validate the visibility of checkboxes, based on the product the user selected.
// there are some features that the user cannot select if he/she chooses a particular product
// so this validation is used so that the users won't waste their money on unavailable features
function validate_product_features() {
	var choose_product = document.getElementById("choose_product").value;
	display_all_checkboxes();
	if(choose_product != "") {
		hide_product_feature_if_choose_a_product(choose_product);
	}	
}

// calculate cost
function calculateCostPerLaptop(choose_product) {
	var LaptopObject = 
	{"Apple Surface Pro X ($1,000)": 1000, 
	"IBM ThinkPad IQ 900 ($500)": 500, 
	"Microsoft Macbook Air 20 ($800)": 800 };
	var LaptopCost = LaptopObject[choose_product];
	var FeaturesArray = [ 
		"RAM8GB", "RAM16GB", "RAM32GB", 
		"Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB", 
		"StorageHDD", "StorageSSD",
		"OSLinux", "OSmacOS", "OSWindows", "OSChromeOS"
	];
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
	return (LaptopCost + FeatureCost);
}

// store all inputs
function storecustomerinfo() {

	var idValue = [
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
	"quantity",
	"write_more", 
	];
	for(var i = 0; i < idValue.length; i++) {
		var id = idValue[i];
		var key = id;
		sessionStorage.setItem(key, document.getElementById(id).value);
	}

	// lets call a set of checkboxes that have the same "name" attribute as a "checkboxes class"
	// store the checkboxes classes
	// create an array of checkboxes classes' ids
	var idCheckBoxes = [
		"preferred_contact",
		"memory",
		"storage", 
		"storage_device",
		"OS" 
	];
	// create an array of checkboxes in each checkboxes classes 
	var idCheckBoxesArray = {
		"preferred_contact": ["preferemail", "preferpost", "preferphone"],
		"memory": ["RAM8GB", "RAM16GB", "RAM32GB"],
		"storage": ["Storage128GB", "Storage256GB", "Storage512GB", "Storage1TB"], 
		"storage_device": ["StorageHDD", "StorageSSD"],
		"OS": ["OSLinux", "OSmacOS", "OSWindows", "OSChromeOS"] 
	};
	// iterate through every checkboxes class
	for(var i = 0; i < idCheckBoxes.length; i++) {
		var name_id = idCheckBoxes[i];
		var name_list = idCheckBoxesArray[name_id];
		var name_Array = [];
		for(var j = 0; j < name_list.length; j++) {
			var id = name_list[j];
			var key = id;
			var check_id = document.getElementById(id).checked;
			sessionStorage.setItem(key, check_id);
			if(check_id) {
			   var value_id = document.getElementById(id).value;
				name_Array.push(value_id);
			}
		}
		var name_key = name_id;
		sessionStorage.setItem(name_key, name_Array.join(", "));
	}
}

// main function for enquiry form onsubmit
function enquiry_form() {

	var first_name = document.getElementById("first_name").value;
	var last_name = document.getElementById("last_name").value;
	var state = document.getElementById("state").value;
	var postcode = document.getElementById("postcode").value;
	var phone_number = document.getElementById("phone_number").value;
  var choose_product = document.getElementById("choose_product").value;
	var quantity = document.getElementById("quantity").value;

	var ErrMsg = "";

	// disable validation in js
	var debug = true;
	if(!debug) {
		// validate data entered
		ErrMsg += validate_enquiry_form(
			first_name, 
			last_name,
			state,
			postcode,
			phone_number, 
			quantity);

		// When an user chooses a laptop, some features will be unavailable
		// this ensures that the unavailable features will not be counted in the total cost
		ErrMsg += validate_product_feature_after_submit(choose_product);
	}
		
	// the returned boolean valid value
	// form can only be submitted if valid = true
	var valid = true;
	//alert error message
	if(ErrMsg != "") {
		var Sorry = "Sorry, there are a few things you need to fix before you submit the form:\n";
		ErrMsg = Sorry + ErrMsg;
		alert(ErrMsg);
		valid = false;
	}

	// calculate and store the price
	if(choose_product != "" && !isNaN(quantity)) {
		var cost_per_laptop = calculateCostPerLaptop(choose_product);
		var order_cost = quantity * cost_per_laptop;
		sessionStorage.cost_per_laptop = cost_per_laptop;
		sessionStorage.order_cost = order_cost;
	}
	else {
		sessionStorage.cost_per_laptop = 0;
		sessionStorage.order_cost = 0;
	}
	// store the checkboxes and radios in sessionStorage, after validate 
	storecustomerinfo();

	// if not valid the form will not send the data
	return valid;
}

// prefill form
function prefill_form() {
	var idValue = [
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
		"quantity",
		"write_more"  
	];
	for(var i = 0; i < idValue.length; i++) {
		var id = idValue[i];
		var key = id;
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
			document.getElementById(id).checked = false;
			if(sessionStorage.getItem(key) == "true") {
				document.getElementById(id).checked = sessionStorage.getItem(key);
			}
		}	
	}
}


// display product image
function display_product_image() {
	var choose_product = document.getElementById("choose_product").value;
	switch(choose_product) {
		case "Apple Surface Pro X ($1,000)":
			document.getElementById("enquire_product_figure").style.display = "";
			document.getElementById("enquire_product_img").src = "images/applelaptop.jpg";
			document.getElementById("enquire_product_figcaption").textContent = "Apple Surface Pro X";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			document.getElementById("enquire_product_figure").style.display = "";
			document.getElementById("enquire_product_img").src = "images/ibmlaptop.jpg";
			document.getElementById("enquire_product_figcaption").textContent = "IBM ThinkPad IQ 900";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			document.getElementById("enquire_product_figure").style.display = "";
			document.getElementById("enquire_product_img").src = "images/microsoftlaptop.jpg";
			document.getElementById("enquire_product_figcaption").textContent = "Microsoft Macbook Air 20";
			break;
		default:
			document.getElementById("enquire_product_figure").style.display = "none";
	}
}

// when the user chooses a product, validate the features and display the product image
function choosing_product() {
	display_product_image();
	validate_product_features();
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
	validate_product_features();
	// dynamically validate the features when the user choose the product
	document.getElementById("choose_product").onchange = choosing_product;
	// validate the form and store the data after click submit
	document.getElementById("product_enquiry").onsubmit = enquiry_form;
}

window.onload = init;