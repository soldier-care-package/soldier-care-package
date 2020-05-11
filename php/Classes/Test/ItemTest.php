<?php
namespace Cohort28SCP\SoldierCarePackage\Test;

require_once(dirname(__DIR__,2) . "/lib/uuid.php");
require_once(dirname(__DIR__) . "/autoload.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Request, Donation, Item};



/**
 * Full PHPUnit test for the Item class
 *
 * This is a complete PHPUnit test of the Item class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Item
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/

class ItemTest extends SoldierCarePackageTest {

	/**
	 * Donation that the Item came from; this is for foreign key relations
	 * @var Profile $donation
	 **/
	protected $donation;

	/**
	 * Request that the Item came from; this is for foreign key relations
	 * @var Request $request
	 **/
	protected $request;

	/**
	 * tracking number for this item
	 * @var string @VALID_TRACKING_NUMBER
	 **/
	protected $VALID_TRACKING_NUMBER = null;


	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		$password = "abc123";
		$this -> VALID_PROFILE_HASH = $password_hash ($password, PASSWORD_ARGON2I, ["time_cost" => 45]);


		// create and insert a Profile to own the test Request
		$this->profile = new Profile(generateUu idV4(), null, "@handle",
			"https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "this is the test bio.",
			"Albuquerque", "testemail@gmail.com", "profileHash", "Lilly Poblano",
			"2nd class private", "NM", "Soldier", "LillyP",
			"87110");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_REQUESTDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

	}

}