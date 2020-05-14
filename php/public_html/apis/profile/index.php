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


	}
}