<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Request};


/**
 * api for the Request class
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
	$requestProfileId = filter_input(INPUT_GET, "requestProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$requestContent = filter_input(INPUT_GET, "requestContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$requestDate = filter_input(INPUT_GET, "requestDate", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that request is returned, otherwise all requests are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific request or all requests and update reply
		if(empty($id) === false) {
			$reply->data = Request::getRequestByRequestId($pdo, $id);
		} else if(empty($requestProfileId) === false) {
			// if the user is logged in grab all the request by that user based  on who is logged in
			$reply->data = Request::getRequestByRequestProfileId($pdo, $requestProfileId)->toArray();

		} else {
			$requests = Request::getAllRequests($pdo)->toArray();
			$requestProfiles = [];
			foreach($requests as $request){
				$profile = 	Profile::getProfileByProfileId($pdo, $request->getRequestProfileId()->toString());
				$requestProfiles[] = (object)[
					"requestId"=>$request->getRequestId(),
					"requestProfileId"=>$request->getRequestProfileId(),
					"requestContent"=>$request->getRequestContent(),
					"requestDate"=>$request->getRequestDate()->format("U.u") * 1000,
					"profileAvatarUrl"=>$profile->getProfileAvatarUrl(),
					"profileBio"=>$profile->getProfileBio(),
					//todo need to include all information that i want to pull with all request ex name, username maybe items
				];
			}
			$reply->data = $requestProfiles;
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post requests", 401));
		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using
		// file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that
		// reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that
		// allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure request content is available (required field)
		if(empty($requestObject->requestContent) === true) {
			throw(new \InvalidArgumentException ("No content for Request.", 405));
		}

		// make sure request date is accurate (optional field)
		if(empty($requestObject->requestDate) === true) {
			$requestObject->requestDate = null;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the request to update
			$request = Request::getRequestByRequestId($pdo, $id);
			if($request === null) {
				throw(new RuntimeException("Request does not exist", 404));
			}

			//enforce the end user has a JWT token


			//enforce the user is signed in and only trying to edit their own request
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !==
				$request->getRequestProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this request", 403));
			}

			validateJwtHeader();

			// update all attributes
			$request->setRequestContent($requestObject->requestContent);
			$request->update($pdo);

			// update reply
			$reply->message = "Request updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post requests", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new request and insert into the database
			$request = new Request(generateUuidV4()->toString(), $_SESSION["profile"]->getProfileId()->toString(),
				$requestObject->requestContent, null);
			$request->insert($pdo);

			// update reply
			$reply->message = "Request created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Request to be deleted
		$request = Request::getRequestByRequestId($pdo, $id);
		if($request === null) {
			throw(new RuntimeException("Request does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own request
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $request->getRequestProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this request", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete request
		$request->delete($pdo);
		// update reply
		$reply->message = "Request deleted OK";
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