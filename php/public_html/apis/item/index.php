<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Cohort28SCP\SoldierCarePackage\{Request, Donation, Item};


/**
 * api for the Item class
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

	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$itemRequestId = filter_input(INPUT_GET, "itemRequestId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$itemDonationId = filter_input(INPUT_GET, "itemDonationId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$itemTrackingNumber = filter_input(INPUT_GET, "item tracking number", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$itemUrl = filter_input(INPUT_GET, "item url", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}


	// handle GET request - if id is present, that item is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific item
		if(empty($id) === false) {
			$reply->data = Item::getItemByItemId($pdo, $id);
		} else if(empty($itemRequestId) === false) {
			// if the user is logged in grab all the items by that user based  on who is logged in
			$reply->data = Item::getItemsByItemRequestId($pdo, $itemRequestId)->toArray();

		} else if(empty($itemDonationId) === false) {
			$reply->data = Item::getItemsByItemDonationId($pdo, $itemDonationId)->toArray();


	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post items for request/donation", 401));

		}

		$requestContent = file_get_contents("php://input");


		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using
			// file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP
			// function that reads a file into a string. The argument for the function, here, is "php://input". This is a
			// read only stream that allows raw data to be read from the front end request which is, in this case, a JSON
			// package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure item Tracking number is available (optional field)

		if(empty($requestObject->itemTrackingNumber) === true) {
			$requestObject->itemTrackingNumber = null;
		}

		// make sure itemUrl is accurate (required field)
		if(empty($requestObject->itemUrl) === true) {
			throw(new \InvalidArgumentException ("No url for item", 405));
		}

		//perform the actual put or post


		} if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["request"]) === true) {
				throw(new \InvalidArgumentException("you must start a request to post item", 403));
		}
// else if(empty($_SESSION["donation"]) === true) {
//				throw(new \InvalidArgumentException("you must be logged in to post donation", 403));
//			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new item and insert into the database
			$item = new Item(generateUuidV4()->toString(), null, $_SESSION["request"]->getRequestId()->toString(), null,  $requestObject->itemUrl);
			$item->insert($pdo);

			// update reply
			$reply->message = "Item created OK";

//			$item = new Item(generateUuidV4()->toString(), $_SESSION["donation"]->getDonationId()->toString(), $requestObject->itemRequestId, null, null);
//			$item->insert($pdo);
//
//			// update reply
//			$reply->message = "Donation created OK";
		}
		//perform the put
		if($method ==="PUT") {

			//retrieve the item to update
			$item = Item ::getItemByItemId($pdo, $id);
			if ($item === null) {
				throw(new RuntimeException("Item does not exist",404));
			}
			validateJwtHeader();

			//accept Item
			//todo I need to allow donor to remove themselves from Item
			$item->setItemDonationId($_SESSION["donation"]->getDonationId());

			//Update tracking number for Item
			if(empty($requestObject->itemTrackingNumber) === false) {
				$item->setItemTrackingNumber($requestObject->itemTrackingNumber);
			}
			else if(empty($requestObject->itemTrackingNumber) === true) {
				$item->setItemTrackingNumber(null);
			}
				$reply->message="Item Updated successfully";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Item to be deleted
		$item = Item::getItemByItemId($pdo, $id);
		if($item === null) {
			throw(new RuntimeException("Item does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own item
		if(empty($_SESSION["request"]) === true || $_SESSION["request"]->getRequestId()->toString() !== $item->getItemRequestId()->toString()) {
			if(empty ($item->getDonationId()) === false){
				throw(new \InvalidArgumentException("Item is already is accepted by donor cannot make any changes"));
			}
			throw(new \InvalidArgumentException("You are not allowed to delete this item", 403));
		}
//			else if(empty($_SESSION["donation"]) === true || $_SESSION["donation"]->getDonationId()->toString() !== $item->getItemDonationId()->toString()) {
//				throw(new \InvalidArgumentException("You are not allowed to delete this item", 403));
//			}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete tweet
		$item->delete($pdo);
		// update reply
		$reply->message = "Item deleted OK";
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

////verify the session, start if not active
//if(session_status() !== PHP_SESSION_ACTIVE) {
//	session_start();
//}
//
////prepare an empty reply
//$reply = new stdClass();
//$reply->status = 200;
//$reply->data = null;
//try {
//
//	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
//	$pdo = $secrets->getPdoObject();
//
//
//	//determine which HTTP method was used
//	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
//
//	//sanitize input
//
//	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$itemDonationId = filter_input(INPUT_GET, "itemDonationId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	var_dump($itemDonationId);
//	$itemRequestId = filter_input(INPUT_GET, "itemRequestId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	var_dump($itemRequestId);
//	$itemTrackingNumber = filter_input(INPUT_GET, "itemTrackingNumber", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$itemUrl = filter_input(INPUT_GET, "itemUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//
//	//make sure the id is valid for methods that require it
//	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
//		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
//	}
//
//	// handle GET request - if id is present, that item is returned, otherwise all items are returned
//	if($method === "GET") {
//		//set XSRF cookie
//		setXsrfCookie();
//
//		//gets  a specific item associated based on its composite key
//		if ($itemRequestId !== null && $itemDonationId !== null && $id !== null) {
//			$item = Item::getItemByRequestIdAndItemDonationIdAndId($pdo, $itemRequestId, $itemDonationId, $id);
//
//
//			if($item!== null) {
//				$reply->data = $item;
//			}
//		}else if(empty($id) === false) {
//				$reply->data = Item::getItemByItemId($pdo, $id);
//			//if none of the search parameters are met throw an exception
//		} else if(empty($itemRequestId) === false) {
//			$reply->data = Item::getItemsByItemRequestId($pdo, $itemRequestId)->toArray();
//			//get all the items associated with the DonationId
//		} else if(empty($itemDonationId) === false) {
//			$reply->data = Item::getItemsByItemDonationId($pdo, $itemDonationId)->toArray();
//		} else {
//			throw new InvalidArgumentException("incorrect search parameters ", 404);
//		}
//
//	} else if($method === "POST" || $method === "PUT") {
//
//		//decode the response from the front end
//		$requestContent = file_get_contents("php://input");
//		$requestObject = json_decode($requestContent);
//
//		if(empty($requestObject->itemRequestId) === true) {
//			throw (new \InvalidArgumentException("No Request linked to item", 405));
//		}
//
//		if(empty($requestObject->itemDonationId) === true) {
//			throw (new \InvalidArgumentException("No Donation linked to item", 405));
//		}
//
//		if($method === "POST") {
//
//			//enforce that the end user has a XSRF token.
//			verifyXsrf();
//
//			//enforce the end user has a JWT token
//			//validateJwtHeader();
//
//			// enforce the user is signed in
//			if(empty($_SESSION["request"]) === true) {
//				throw(new \InvalidArgumentException("you must be logged in to post items in requests", 403));
//			}
//
//			if(empty($_SESSION["donation"]) === true) {
//				throw(new \InvalidArgumentException("you must be logged in to accept donation", 403));
//			}
//
//			validateJwtHeader();
//
//			$item = new Item($_SESSION["request"]->getRequestId()->toString(), $requestObject->itemRequestId);
//			$item->insert($pdo);
//			$reply->message = "item Request successful";
//
//		$item = new Item($_SESSION["donation"]->getDonationId()->toString(), $requestObject->itemDonationId);
//		$item->insert($pdo);
//		$reply->message = "item Donation successful";
//
//		} else if($method === "DELETE") {
//
//			//enforce the end user has a XSRF token.
//			verifyXsrf();
//
//			//enforce the end user has a JWT token
//			validateJwtHeader();
//
//			//grab the item by its composite key
//			$item = Item::getItemByItemIdAndItemRequestId($pdo, $requestObject->itemRequestId, $requestObject->itemId);
//			if($item === null) {
//				throw (new RuntimeException("Item does not exist"));
//			}
//
//			//enforce the user is signed in and only trying to edit their own item
//			if(empty($_SESSION["request"]) === true || $_SESSION["request"]->getRequestId()->toString() !== $item->getItemRequestId()->toString()) {
//				throw(new \InvalidArgumentException("You are not allowed to delete this item", 403));
//			}
//
//			//validateJwtHeader();
//
//			//preform the actual delete
//			$item->delete($pdo);
//
//			//update the message
//			$reply->message = "Item successfully deleted";
//		}
//		// if any other HTTP request is sent throw an exception
//	} else {
//		throw new \InvalidArgumentException("invalid http request", 400);
//	}
//	//catch any exceptions that is thrown and update the reply status and message
//} catch(\Exception | \TypeError $exception) {
//	$reply->status = $exception->getCode();
//	$reply->message = $exception->getMessage();
//}
//
//header("Content-type: application/json");
//if($reply->data === null) {
//	unset($reply->data);
//}
//
//// encode and return reply to front end caller
//echo json_encode($reply);
