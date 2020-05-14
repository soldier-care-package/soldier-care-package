<?php

//require_once

use Cohort28SCP\SoldierCarePackage\Profile;

/**
 * API for the Profile class
 *
 * @author Nohemi Tarango
 **/
// Verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try{
	// Grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
	$pdo = $secrets->getPdoObjects();

	// Determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// Sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileUsername = filter_input(INPUT_GET, "profileUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// Make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("Id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// Set XSRF cookie
		setXsrfCookie();

		// Get a post by content
		if(empty($id) === false) {
			$reply->data = Profile::getProfileByProfileId($pdo, $id);
		} else if(empty($profileUsername) === false) {
			$reply->data = Profile::getProfileUsername($pdo, $profileUsername);
		} else if(empty($profileEmail) === false) {
			$reply->data = Profile::getProfileEmail($pdo, $profileEmail);
		}

	} else if($method === "PUT") {
		// Enforce that the XSRF token is present in the header
		verifyXsrf();

		// Enforce the end user has a JWT token

		// Enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		validateJwtHeader();

		// Decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// Retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}


	}
}