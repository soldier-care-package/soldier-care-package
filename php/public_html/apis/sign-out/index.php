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
