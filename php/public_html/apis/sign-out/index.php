<?php

require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";

use Cohort28SCP\SoldierCarePackage\Profile;

/**
 * API for signing out
 *
 * @author Nohemi Tarango
 **/

// Verify the XSRF challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Prepare the default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	// Grab the mySQL connection
	// Grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
	$pdo = $secrets->getPdoObjects();

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "GET") {
		$_SESSION = [];
		$reply->message = "You are now signed out";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);
