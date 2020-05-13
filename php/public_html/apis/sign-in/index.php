<?php

require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
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
		$secrets = new \Secrets("/etc/apache2/capstone-mysql/ddctwitter.ini");
		$pdo = $secrets->getPdoObjects();

		// determine which HTTP method is being used
		$method = array_key_exists("HTTP_X_HTTP_MEHTOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_MEHTOD"] : $_SERVER["REQUEST_METHOD"];

		// If method
	}