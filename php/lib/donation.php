<?php
require_once(dirname(__DIR__, 1) . "/Classes/Donation.php");
require_once("uuid.php");
require_once("configs.php");

use Cohort28SCP\SoldierCarePackage\Donation;

// The pdo object has been created for you.
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets =  new Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
$pdo = $secrets->getPdoObject();