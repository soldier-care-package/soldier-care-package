<?php
namespace Cohort28SCP\SoldierCarePackage\Test;

require_once(dirname(__DIR__,2) . "/lib/uuid.php");
require_once(dirname(__DIR__) . "/autoload.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Request};



/**
 * Full PHPUnit test for the Donation class
 *
 * This is a complete PHPUnit test of the Donation class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Donation
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/

class DonationTest extends SoldierCarePackageTest {

	/**
	 * Profile that created the Donation; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * timestamp of the donation; this starts as null and is assigned later
	 * @var \DateTime $VALID_DONATIONDATE
	 **/
	protected $VALID_DONATIONDATE = null;

	/**
	 * Valid timestamp to use as sunriseDonationDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetDonationDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		$password = "abc123";
		$profileHash = VALID_PROFILE_HASH($password, PASSWORD_ARGON2I, ["time_cost" => 45]);


		// create and insert a Profile to own the test Donation
		$this->profile = new Profile(generateUuidV4(), null, "@handle",
			"https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "this is the test bio.",
			"Albuquerque", "testemail@gmail.com", "profileHash", "Charlie Miller",
			"2nd class private", "NM", "Sender", "MillerC",
			"87110" );
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_DONATIONDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

	}

	/**
	 * test inserting a valid Donation and verify that the actual mySQL data matches
	 *
	 * @throws \Exception
	 */
	public function testInsertValidDonation() : void {


		// create a new Donation and insert to into mySQL
		$donationId = generateUuidV4()->toString;
		$donation = new Donation($donationId, $this->profile->getProfileId()->toString(), $this->VALID_DONATIONDATE);
		$donation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoDonation = Donation::getDonationByDonationId($this->getPDO(), $donation->getDonationId()->toString());

		$this->assertEquals($pdoDonation->getDonationId()->toString(), $donationId->toString());
		$this->assertEquals($pdoDonation->getDonationProfileId(), $donation->getDonationProfileId()->toString());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoDonation->getDonationDate()->getTimestamp(), $this->VALID_DONATIONDATE->getTimestamp());
	}

	/**
	 * test creating a Donation and then deleting it
	 *
	 * @throws \Exception
	 */
	public function testDeleteValidDonation() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("donation");

		// create a new Donation and insert to into mySQL
		$donationId = generateUuidV4();
		$donation = new Donation($donationId, $this->profile->getProfileId(), $this->VALID_DONATIONDATE);
		$donation->insert($this->getPDO());

		// delete the donation from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("donation"));
		$donation->delete($this->getPDO());

		// grab the data from mySQL and enforce the Request does not exist
		$pdoDonation = Donation::getDonationByDonationId($this->getPDO(), $donation->getDonationId());
		$this->assertNull($pdoDonation);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("donation"));
	}

	/**
	 * test inserting a Donation and regrabbing it from mySQL
	 *
	 * @throws \Exception
	 */
	public function testGetValidDonationByDonationProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("donation");

		// create a new Donation and insert to into mySQL
		$donationId = generateUuidV4();
		$donation = new Donation($donationId, $this->profile->getProfileId(), $this->VALID_DONATIONDATE);
		$donation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Donation::getDonationByDonationProfileId($this->getPDO(), $donation->getDonationProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("donation"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Cohort28SCP\\SoldierCarePackage\\Donation", $results);

		// grab the result from the array and validate it
		$pdoRequest = $results[0];

		$this->assertEquals($pdoDonation->getDonationId(), $donationId);
		$this->assertEquals($pdoDonation->getDonationProfileId(), $this->profile->getProfileId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoDonation->getDonationDate()->getTimestamp(), $this->VALID_DONATIONDATE->getTimestamp());
	}

	/**
	 * test grabbing a Donation by DonationId
	 *
	 * @throws \Exception
	 */
	public function testGetValidDonationByDonationId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("donation");

		// create a new Donation and insert to into mySQL
		$donationId = generateUuidV4();
		$donation = new Donation($donationId, $this->profile->getProfileId(), $this->VALID_DONATIONDATE);
		$donation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Donation::getDonationByDonationId($this->getPDO(), $donation->getDonationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("donation"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Cohort28SCP\\SoldierCarePackage\\Donation", $results);

		// grab the result from the array and validate it
		$pdoDonation = $results[0];
		$this->assertEquals($pdoDonation->getDonationId(), $donationId);
		$this->assertEquals($pdoDonation->getDonationProfileId(), $this->profile->getProfileId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoDonation->getDonationDate()->getTimestamp(), $this->VALID_DONATIONDATE->getTimestamp());
	}




}