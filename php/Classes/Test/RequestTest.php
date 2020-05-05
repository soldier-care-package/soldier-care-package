<?php
namespace Cohort28SCP\SoldierCarePackage\Test;

require_once(dirname(__DIR__, 1) . "/Request.php");
require_once("uuid.php");
require_once("configs.php");
require_once(dirname(__DIR__) . "/autoload.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Request};
/*
// The pdo object has been created for you.
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets =  new Secrets("/etc/apache2/capstone-mysql/cohort28/scp.ini");
$pdo = $secrets->getPdoObject();
*/


/**
 * Full PHPUnit test for the Request class
 *
 * This is a complete PHPUnit test of the Request class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Request
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/

class RequestTest extends SoldierCarePackageTest {

	/**
	 * Profile that created the Request; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * content of the Request
	 * @var string $VALID_REQUESTCONTENT
	 **/
	protected $VALID_REQUESTCONTENT = "test of request content";

	/**
	 * content of the updated Request
	 * @var string $VALID_REQUESTCONTENT2
	 **/
	protected $VALID_REQUESTCONTENT2 = "test of request content #2";

	/**
	 * timestamp of the request; this starts as null and is assigned later
	 * @var \DateTime $VALID_REQUESTDATE
	 **/
	protected $VALID_REQUESTDATE = null;

	/**
	 * Valid timestamp to use as sunriseRequestDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetRequestDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Profile to own the test Tweet
		$this->profile = new Profile(generateUuidV4(), null, "@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de", $this->VALID_PROFILE_HASH, "testemail@gmail.com");
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


	/**
	 * test inserting a valid Request and verify that the actual mySQL data matches
	 **/
	public function testInsertValidRequest() : void {


		// create a new Request and insert to into mySQL
		$requestId = generateUuidV4();
		$request = new Request($requestId, $this->profile->getProfileId(), $this->VALID_REQUESTCONTENT, $this->VALID_REQUESTDATE);
		$request->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRequest = Request::getRequestByRequestId($this->getPDO(), $request->getRequestId());

		$this->assertEquals($pdoRequest->getRequestId()->toString(), $requestId->toString());
		$this->assertEquals($pdoRequest->getRequestProfileId(), $request->getRequestId()->toString());
		$this->assertEquals($pdoRequest->getRequestContent(), $this->VALID_REQUESTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRequest->getRequestDate()->getTimestamp(), $this->VALID_REQUESTDATE->getTimestamp());
	}


	/**
	 * test inserting a Request, editing it, and then updating it
	 **/
	public function testUpdateValidRequest(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("request");

		// create a new Request and insert to into mySQL
		$requestId = generateUuidV4();
		$request = new Request($requestId, $this->profile->getProfileId(), $this->VALID_REQUESTCONTENT, $this->VALID_REQUESTDATE);
		$request->insert($this->getPDO());

		// edit the Request and update it in mySQL
		$request->setRequestContent($this->VALID_REQUESTCONTENT2);
		$request->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRequest = Request::getRequestByRequestId($this->getPDO(), $request->getRequestId());
		$this->assertEquals($pdoRequest->getRequestId(), $requestId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("request"));
		$this->assertEquals($pdoRequest->getRequestProfileId()->toString(), $this->profile->getProfileId()->toString());
		$this->assertEquals($pdoRequest->getRequestContent(), $this->VALID_REQUESTCONTENT2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRequest->getRequestDate()->getTimestamp(), $this->VALID_REQUESTDATE->getTimestamp());
	}

	/**
	 * test creating a Request and then deleting it
	 **/
	public function testDeleteValidRequest() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("request");

		// create a new Request and insert to into mySQL
		$requestId = generateUuidV4();
		$request = new Request($requestId, $this->profile->getProfileId(), $this->VALID_REQUESTCONTENT, $this->VALID_REQUESTDATE);
		$request->insert($this->getPDO());

		// delete the Request from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("request"));
		$request->delete($this->getPDO());

		// grab the data from mySQL and enforce the Request does not exist
		$pdoRequest = Request::getRequestByRequestId($this->getPDO(), $request->getRequestId());
		$this->assertNull($pdoRequest);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("request"));
	}

	/**
	 * test inserting a Request and regrabbing it from mySQL
	 **/
	public function testGetValidRequestByRequestProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("request");

		// create a new Request and insert to into mySQL
		$requestId = generateUuidV4();
		$request = new Request($requestId, $this->profile->getProfileId(), $this->VALID_REQUESTCONTENT, $this->VALID_REQUESTDATE);
		$request->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Request::getRequestByRequestProfileId($this->getPDO(), $request->getRequestProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("request"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoRequest = $results[0];

		$this->assertEquals($pdoRequest->getRequestId(), $requestId);
		$this->assertEquals($pdoRequest->getRequestProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRequest->getRequestContent(), $this->VALID_REQUESTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRequest->getRequestDate()->getTimestamp(), $this->VALID_REQUESTDATE->getTimestamp());
	}

}
