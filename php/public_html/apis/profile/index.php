<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
	$pdo = $secrets->getPdoObject();

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
			throw(new InvalidArgumentException("You are not allowed to access this profile", 403));
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

		// Profile Username
		if(empty($requestObject->profileUsername) === true) {
			throw(new InvalidArgumentException("No profile username", 405));
		}

		// Profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new InvalidArgumentException("No profile email present", 405));
		}

		//profile phone # | if null use the profile phone that is in the database
//		if(empty($requestObject->profilePhone) === true) {
//			$requestObject->ProfilePhone = $profile->getProfilePhone();
//		}

		$profile->setProfileUsername($requestObject->profileUsername);
		$profile->setProfileEmail($requestObject->profileEmail);
//		$profile->setProfilePhone($requestObject->profilePhone);
		$profile->update($pdo);

		// Update reply
		$reply->message = "Profile information updated";

	} else if($method === "DELETE") {

		// Verify the XSRF token
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();

		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist"));
		}

		// Enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()->toString()) {
			throw(new InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		validateJwtHeader();

		// Delete the post from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";

	} else {
		throw(new InvalidArgumentException("Invalid HTTP Request", 400));
	}
	// Catch any exceptions that were thrown and update the status and message state variable fields
} catch(Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// Encode and return reply to front end caller
echo json_encode($reply);
