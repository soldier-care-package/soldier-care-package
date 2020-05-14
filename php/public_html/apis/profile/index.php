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

}