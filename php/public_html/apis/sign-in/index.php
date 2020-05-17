<?php

require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__,3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Cohort28SCP\SoldierCarePackage\Profile;

/**
 * API for handling sign-in
 *
 * @author Nohemi Tarango
 **/
	//prepare an empty reply
	$reply = new stdClass();
	$reply->status = 200;
	$reply->data = null;
	try {
		// start session
		if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		// grab mySQL statement
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
		$pdo = $secrets->getPdoObject();

		// determine which HTTP method is being used
		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

		// If method is post, handle the sign in logic
		if($method === "POST") {

			// Make sure the XSRF token is valid
			verifyXsrf();

			// Process the request content and decode the json object into a php object
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			// Check to make sure the password and email field is not empty
			if(empty($requestObject->profileEmail) === true) {
				throw(new InvalidArgumentException("Email address not provided", 401));
			} else {
				$profileEmail =filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
			}

			if(empty($requestObject->profilePassword) === true) {
				throw(new InvalidArgumentException("Must enter a password", 401));
			} else {
				$profilePassword = $requestObject->profilePassword;
			}

			// grab the profile from the database by the email provided
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if(empty($profile) === true) {
				throw(new InvalidArgumentException("Invalid email", 401));
			}
//			$profile->setProfileActivationToken(null);
//			$profile->update($pdo);

			// Verify that the hash is correct
			if(password_verify($requestObject->profilePassword, $profile->getProfileHash()) === false) {
				throw(new InvalidArgumentException("Password or email is incorrect", 401));
			}

			// Grab profile from database and put into a session
			$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());

			$_SESSION["profile"] = $profile;

			// Create the Auth payload
			$authObject = (object) [
				"profileId" =>$profile->getProfileId(),
				"profileUsername" =>$profile->getProfileUsername()
			];

			// Create and set the JWT Token
			setJwtAndAuthHeader("auth", $authObject);

			$reply->message = "Sign in was successful";
		} else {
			throw(new InvalidArgumentException("Invalid HTTP method request", 418));
		}

		// If an exception is thrown update
	} catch(Exception | TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
	header("Content-type: application/json");
	// Encode and return reply to front end caller
	echo json_encode($reply);

