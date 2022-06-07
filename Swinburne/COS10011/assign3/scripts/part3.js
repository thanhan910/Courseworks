/* Filename: part3.js
Target: pix_order.php
Purpose : check the form inputs
Author: Thanh An Nguyen - 103125896
Date written: April 22nd, 2021
*/

"use strict"; // prevent the use of global variables

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

// I still need this for Assignment 3 to dynamically alter the webpage 
// when the user tries to change the product
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

// main function for form onsubmit
function fix_order_form() {
	var ErrMsg = "";	
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
			document.getElementById("fix_order_product_figure").style.display = "";
			document.getElementById("fix_order_product_img").src = "images/applelaptop.jpg";
			document.getElementById("fix_order_product_figcaption").textContent = "Apple Surface Pro X";
			break;
		case "IBM ThinkPad IQ 900 ($500)":
			document.getElementById("fix_order_product_figure").style.display = "";
			document.getElementById("fix_order_product_img").src = "images/ibmlaptop.jpg";
			document.getElementById("fix_order_product_figcaption").textContent = "IBM ThinkPad IQ 900";
			break;
		case "Microsoft Macbook Air 20 ($800)":
			document.getElementById("fix_order_product_figure").style.display = "";
			document.getElementById("fix_order_product_img").src = "images/microsoftlaptop.jpg";
			document.getElementById("fix_order_product_figcaption").textContent = "Microsoft Macbook Air 20";
			break;
		default:
			document.getElementById("fix_order_product_figure").style.display = "none";
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
	validate_product_features(); // I still need this
	// dynamically validate the features when the user choose the product
	document.getElementById("choose_product").onchange = choosing_product;
	// validate the form and store the data after click submit
	document.getElementById("fix_order_form").onsubmit = fix_order_form;
	// cancel button
	document.getElementById("fix_order_cancelButton").onclick = cancelButton;
}


function cancelButton() {
	// location.href = "index.php";
	window.location = "index.php";
	// clear storage
	sessionStorage.clear();
}

window.onload = init;