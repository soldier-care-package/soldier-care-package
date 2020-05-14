<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__,3) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Cohort28SCP\SoldierCarePackage\Profile;

/**
 * API to check profile activation status
 *
 * @author Nohemi Tarango
 **/
// Check the session. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	// Grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
	$pdo = $secrets->getPdoObjects();

	// Check the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD, $_SERVER") ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// Sanitize input
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);

	// Make sure the activation token is the correct size
	if(strlen($activation) !== 32) {
		throw(new \InvalidArgumentException("Activation has an incorrect length", 405));
	}

	// Verify that the activation token is a string value of a hexadecimal
	if(ctype_xdigit($activation) === false) {
		throw(new \InvalidArgumentException("Activation is empty or has invalid contents", 405));
	}

	// Handle the GET HTTP request
	if($method === "GET") {

		// Set XSRF Cookie
		setXsrfCookie();

		// Find profile associated with the activation token
		$profile = Profile::getProfileByProfileActivationToken($pdo, $activation);

		// Verify the profile is not null
		if($profile !== null) {

			// Make sure the activation token matches
			if($activation === $profile->getProfileActivationToken()) {

				// Set activation to null
				$profile->setProfileActivationToken(null);

				// Update the profile in the database
				$profile->update($pdo);

				// Set the reply for the end user
				$reply->data = "Thank you for activating your account, you will be auto-redirected to your profile shortly.";
			}
		} else {
			// Throw an exception if the activation token does not exist
			throw(new RuntimeException("Profile with this activation code does not exist", 404));
		}
	} else {
		// Throw an exception if the HTTP request is not a GET
		throw(new \InvalidArgumentException("Invalid HTTP method request", 403));
	}

	// Update the reply objects status and message state variables if an exception or type exception was thrown
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

// Prepare and send the reply
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
