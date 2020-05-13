<?php

//require_once

use Cohort28SCP\SoldierCarePackage\Profile;

/**
 * API for the Profile class
 *
 * @author Nohemi Tarango
 **/
// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

//try {
//	// grab the mySQL connection
//	$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
//	$pdo = $secrets->getPdoObject();
//
//	// determine which HTTP method was used
//	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
//
//	// sanitize input
//	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$profileActivationToken = filter_input(INPUT_POST, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$soldierProfiles = filter_input(INPUT_POST, "soldierProfiles", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//
//	// make sure the id is valid for methods that require it
//	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
//		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
//	}
//}
//
//if($method === "GET") {
//	// set XSRF cookie
//	setXsrfCookie();
//
//	// gets a post by content
//	if(empty($id) === false) {
//		$reply->data = Profile::getProfileByProfileId($pdo, $id);
//
//	} else if(empty($profileActivationToken) === false) {
//		$reply->data = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken);
//
//	} else if(empty($soldierProfiles) === false) {
//		$reply->data = Profile::getAllSoldierProfiles($pdo, $soldierProfiles);
//	}
//
//} else if($method === "PUT") {
//	// enforce that the XSRF token is present in the header
//	verifyXsrf();
//
//	// enforce the user is signed in and only trying to edit their own profile
//	if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
//		throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
//	}
//
//	validateJwtHeader();
//
//	//decode the response from the front end
//	$requestContent = file_get_contents("php://input");
//	$requestObject = json_decode($requestContent);
//
//	// retrieve the profile to be updated
//	$profile = Profile::getProfileByProfileId($pdo, $id);
//	if($profile === null) {
//		throw(new RuntimeException("profile does not exist", 404));
//	}
//
//	// profile activation token
//	if(empty($requestObject->profileActivationToken) === true) {
//		throw(new \InvalidArgumentException("No profile activation token", 405));
//	}
//
//	// profile email is a required field
//	if(empty($requestObject));
//}
