<?php
/*
Encrypter - PHP

This a single web page application (tool) made using PHP on backend and HTML, JavaScript on the frontend. We relied on BootStrap CDN for the frontend designing section. The main working of the tool is for encrypting the strings. There are input boxes and buttons on the web page frontend where we can enter the text and password and do either encryption or decryption. The tool (application) can be a very good project for all the PHP beginners as well as web development beginners. The project is hosted at Github at https://github.com/rdofficial/PhpEncrypter, check out the documentation for more infomation. If you find any errors or can do more modifications, then you can freely share your ideas with me at my mail rdofficial192@gmail.com.

Also note that this application is a part of PHP projects series, for more such related projects check out my github account at https://github.com/rdofficial.

Author : Rishav Das
*/

// Creating the function for encryption and decryption
function encrypt(string $text, string $password) {
	/* The function to encrypt a plain utf-8 encoded string to a cipher format using a password. The function will return a encrypted form of string, so we need to catch that returning value to a variable. We will use this function to encrypt the text requested by the user. */

	$key = 0;
	$n  = 0;
	for ($i = 0; $i < strlen($password); $i++) { 
		// Iterating through each character of the password string to generate a key

		if ($n % 2 == 0) {
			$key += ord($password[$i]);
		} else {
			$key -= ord($password[$i]);
		}
		$n += 1;
	}
	// Making the encryption key possitive if its negative
	if ($key < 0) {$key = $key * (-1);}
	$key += strlen($password);

	// Encrypting the user specified string text
	$encryptedText = '';
	for ($i = 0; $i < strlen($text); $i++) { 
		// Iterating through each characters of the string text in order to convert them to cipher format
		
		$encryptedText[$i] = chr((ord($text[$i]) + $key) % 256);
	}

	// Encoding the cipher text into the base64 format
	$encryptedText = base64_encode($encryptedText);
	return $encryptedText;
}

function decrypt(string $text, string $password) {
	/* The function to decrypt a cipher format text to the original plain utf-8 encoded string. The function returns the plain string, so to catch the returning string we need to store the value to a variable right after we call this function. The function will be used in the decryption of the user requested text. Note that the function will succesfully only those strings which are encrypted using the above function, and also you would need the original password. */

	// Decoding the cipher text from base64 format back to the utf-8 encoding
	$text = base64_decode($text);

	$key = 0;
	$n  = 0;
	for ($i = 0; $i < strlen($password); $i++) { 
		// Iterating through each character of the password string to generate a key

		if ($n % 2 == 0) {
			$key += ord($password[$i]);
		} else {
			$key -= ord($password[$i]);
		}
		$n += 1;
	}
	// Making the encryption key possitive if its negative
	if ($key < 0) {$key = $key * (-1);}
	$key += strlen($password);

	// Converting the cipher text back to the plain format text
	$decryptedText = '';
	for ($i = 0; $i < strlen($text); $i++) { 
		// Iterating through each characters of the string text in order to convert them to cipher format
		
		$decryptedText[$i] = chr((ord($text[$i]) - $key) % 256);
	}
	return $decryptedText;
}

// Checking if there is a POST request or a GET request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// If there is a POST request on the page, then we continue the process as per specified

	// Getting the POST request data
	$text = $_POST["text"];  // The user entered text (either for encryption or decryption)
	$password = $_POST["password"];  // The user entered password for the encryption / decryption
	$method = $_POST["method"];  // The POST data parameter specifying wheter to carry out encryption or decryption

	// Checking the method specified
	if ($method == "encryption" || $method == "encrypt") {
		// If the method specified encryption, then continue to encrypt the text with the specified password

		$result = encrypt($text, $password);
		echo $result;
	} elseif ($method == "decryption" || $method == "decrypt") {
		// If the method specified is decryption, then we continue to decrypt the user provided text with the specified password

		$result = decrypt($text, $password);
		echo $result;
	} else {
		// If the method specified by the POST request is neither encryption nor decryption, then we return an error

		echo 'Error : Please specify wheter to encrypt or decrypt';
	}
} else {
	// If the request type on the page is not a POST request, then most possibly its a GET request. So, we start serving the frontend documents

	echo '<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>Encrypter - PHP</title>
</head>
<body>
	<!-- The body section for the page -->

	<!-- The header (navbar) for the page -->
	<nav class="navbar navbar-dark bg-dark">
  		<a class="navbar-brand">Encrypter - PHP</a>
	</nav>

	<!-- The input box container -->
	<div class="container my-2">
		<textarea class="form-control my-1" style="resize: none;" placeholder="Type text here" name="text" rows="4"></textarea>
		<input type="password" class="form-control my-1" placeholder="Enter the password" name="password">
		<button class="btn btn-success mr-3" id="encrypt-btn">Encrypt</button>
		<button class="btn btn-danger ml-3" id="decrypt-btn">Decrypt</button>
	</div>

	<!-- The result container -->
	<hr>
	<div class="container my-1" id="result-container"></div>
</body>

<!-- Linking the required JS by the Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script type="text/javascript">
	// The JavaScript for this frontend page

	// Getting the input box HTML elements
	const text = document.querySelector(`textarea[name="text"]`);
	const password = document.querySelector(`input[name="password"]`);

	const checkUserInputs = () => {
		/* The function to check and verify the user inputs in the text and password fields. If the user enters a empty value or just whitespaces in any of the fields, then the function returns false. Exception is for the text field, there you can enter a hell lot of whitespaces there LOL! ;-). But, remember never end the password input field with a whitespace, otherwise the function would return an error */

		if (text.value.length == 0 || password.value.length == 0) {
			return false;
		} else {
			let blankValue = false;
			for (let i in text) {
				if (i == " ") {
					blankValue = true;
				} else {
					blankValue = false;
				}
			}
			if (blankValue) {
				return false;
			} else {
				return true;
			}
		}
	}

	// Getting the buttons on the HTML document
	const encryptBtn = document.getElementById("encrypt-btn");
	const decryptBtn = document.getElementById("decrypt-btn");

	// Getting the result container HTML element
	const resultContainer = document.getElementById("result-container");

	// Adding the onclick listener to these buttons
	encryptBtn.addEventListener("click", (e) => {
		/* When the user clicks on the encrypt button, this function is called. The function first reads the user inputs and then sends a POST request on this page. */

		// Verifying the user inputs (error message only on blank inputs)
		if (!checkUserInputs()) {
			alert(`Please enter proper details in the input boxes`);
			return 0;
		}

		e.preventDefault();
		// Creating the POST request data
		let data = new FormData();
		data.append("text", text.value);
		data.append("password", password.value);
		data.append("method", "encryption");

		// Sending the POST request to the PHP backend
		fetch("/", {body : data, method : "post"}).then(response => response.text()).then(response => resultContainer.innerHTML = `<h3>Result of encryption :</h3><br><pre style="white-space: pre-wrap">${response}</pre>`);
	});
	decryptBtn.addEventListener("click", (e) => {
		/* When the user clicks on the decrypt button, this function is called. The function first reads the user inputs and then sends a POST request on this page. */

		// Verifying the user inputs (error message only on blank inputs)
                if (!checkUserInputs()) {
                        alert(`Please enter proper details in the input boxes`);
                        return 0;
                }

		e.preventDefault();
		// Creating the POST request data
		let data = new FormData();
		data.append("text", text.value);
		data.append("password", password.value);
		data.append("method", "decryption");

		// Sending the POST request to the PHP backend
		fetch("/", {body : data, method : "post"}).then(response => response.text()).then(response => resultContainer.innerHTML = `<h3>Result of decryption :</h3><br><pre style="white-space: pre-wrap">${response}</pre>`);
	});
</script>
</html>';
}

?>
