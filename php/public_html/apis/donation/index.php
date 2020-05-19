<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Donation};


/**
 * api for the Donation class
 *
 * @author Hannah Miltenberger <hannahmilt@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
	$pdo = $secrets->getPdoObject();



	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input

	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$donationProfileId = filter_input(INPUT_GET, "donationProfile", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$donationDate = filter_input(INPUT_GET, "donationDate", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}

// handle GET request - if id is present, that donation is returned, otherwise all donations are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific donation or all donations and update reply
		if(empty($id) === false) {
			$reply->data = Donation::getDonationByDonationId($pdo, $id);
		} else if(empty($donationProfileId) === false) {
			// if the user is logged in grab all the Donations by that user based  on who is logged in
			$reply->data = Donation::getDonationsByDonationProfileId($pdo, $donationProfileId)->toArray();

		} else {
			$donations = Donation::getAllDonations($pdo)->toArray();
			$donationProfiles = [];
			foreach($donations as $donation){
				$profile = 	Profile::getProfileByProfileId($pdo, $donation->getDonationProfileId());
				$donationProfiles[] = (object)[
					"donationId"=>$donation->getDonationId(),
					"donationProfileId"=>$donation->getDonationProfileId(),
					"donationDate"=>$donation->getDonationDate()->format("U.u") * 1000,
					"profileAvatarUrl"=>$profile->getProfileAvatarUrl(),
				];
			}
			$reply->data = $donationProfiles;
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to accept donations", 401));
		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using
		// file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function
		// that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream
		// that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject

		// make sure donation date is accurate (optional field)
		if(empty($requestObject->donationDate) === true) {
			$requestObject->donationDate = null;
		}


		//perform the actual post
 if($method === "POST") {

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to accept donations", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// create new donation and insert into the database
		$donation = new donation(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->donationDate);
		$donation->insert($pdo);

		// update reply
		$reply->message = "Donation created OK";
	}

} else if($method === "DELETE") {

	//enforce that the end user has a XSRF token.
	verifyXsrf();

	// retrieve the Donation to be deleted
	$donation = Donation::getDonationByDonationId($pdo, $id);
	if($donation === null) {
		throw(new RuntimeException("Donation does not exist", 404));
	}

	//enforce the user is signed in and only trying to edit their own donation
	if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $donation->getDonationProfileId()->toString()) {
		throw(new \InvalidArgumentException("You are not allowed to delete this donation", 403));
	}

	//enforce the end user has a JWT token
	validateJwtHeader();

	// delete donation
	$donation->delete($pdo);
	// update reply
	$reply->message = "Donation deleted OK";
} else {
	throw (new InvalidArgumentException("Invalid HTTP method request", 418));
}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);