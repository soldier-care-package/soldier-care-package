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
	 * Url for this item
	 * @var string @VALID_URL
	 **/
	protected $VALID_URL = null;

	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		$password = "abc123";
		$profileHash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 8]);


		// create and insert a Profile to own the test Test
		$this->profile = new Profile(generateUuidV4()->toString(), null, "@handle",
			"https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "this is the test bio.",
			"APO", "testemail@gmail.com", $profileHash, "Lilly Poblano",
			"2nd class private", "AE", "soldier", "LillyP",
			"87110");
		$this->profile->insert($this->getPDO());

	}

	/**
	 * test inserting a valid Item and verify that the actual mySQL data matches
	 *
	 * @throws \Exception
	 */
	public function testInsertValidItem() : void {


		// create a new Item and insert to into mySQL
		$itemId = generateUuidV4()->toString();
		$item = new Item($itemId, $this->donation->getDonationId()->toString(), $this->request->getRequestId()->toString(), $this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoItem = Item::getItemByItemId($this->getPDO(), $item->getItemId()->toString());
		$this->assertEquals($pdoItem->getItemId(), $itemId);
		$this->assertEquals($pdoItem->getItemDonationId(), $this-> donation->getDonationId()->toString());
		$this->assertEquals($pdoItem->getItemRequestId(), $this->request->getRequestId()->toString());
		$this->assertEquals($pdoItem->getItemTrackingNumber(), $this->VALID_TRACKING_NUMBER);
		$this->assertEquals($pdoItem->getItemUrl(), $this->VALID_URL);
	}

	/**
	 * test inserting a item, editing it, and then updating it
	 *
	 * @throws \Exception
	 */
	public function testUpdateValidItem(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("item");

		// create a new Item and insert to into mySQL
		$itemId = generateUuidV4();
		$item = new Item($itemId, $this->donation->getDonationId(), $this->request->getRequestId(), $this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// edit the Item and update it in mySQL
		$item->setItemDonationId($this->donation);
		$item->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoItem = Item::getItemByItemId($this->getPDO(), $item->getitemId());
		$this->assertEquals($pdoItem->getItemId(), $itemId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("item"));
		$this->assertEquals($pdoItem->getItemDonationId(), $this->donation->getDonationId()->toString());
		$this->assertEquals($pdoItem->getItemRequestId(), $this->request->getRequestId()->toString());
		$this->assertEquals($pdoItem->getItemTrackingNumber(), $this->VALID_TRACKING_NUMBER);
		$this->assertEquals($pdoItem->getItemUrl(), $this->VALID_URL);
	}

	/**
	 * test creating a Item and then deleting it
	 **/
	public function testDeleteValidItem() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("item");

		// create a new Tweet and insert to into mySQL
		$itemId = generateUuidV4();
		$item = new Item($itemId, $this->donation->getDonationId(), $this->request->getReqeustId(), $this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// delete the Item from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("item"));
		$item->delete($this->getPDO());

		// grab the data from mySQL and enforce the Item does not exist
		$pdoItem = Item::getItemByItemId($this->getPDO(), $item->getItemId());
		$this->assertNull($pdoItem);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("item"));
	}

	//fixes //no profileId?
	//get item by requestId
	/**
	 * test inserting a Item and regrabbing it from mySQL
	 *
	 *
	 * @throws \Exception
	 */
	public function testGetValidItemsByItemRequestId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Item");

		// create a new Item and insert to into mySQL
		$itemId = generateUuidV4()->toString();
		$item = new Item($itemId, $this->donation->getDonationId()->toSting(), $this->request->getReqeustId()->toString(),
			$this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Item::getItemsByItemRequestId($this->getPDO(), $item->getItemRequestId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("item"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Cohort28SCP\\SoldierCarePackage\\Donation", $results);

		// grab the result from the array and validate it
		$pdoItem = $results[0];

		$this->assertEquals($pdoItem->getItemId()->toString(), $itemId);
		$this->assertEquals($pdoItem->getRequestId(), $this->request->getRequestId());
	}

	/**
	//	 * test grabbing a Item by ItemId
	//	 *
	//	 * @throws \Exception
	//	 */
	public function testGetValidItemByItemId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("item");

		// create a new Item and insert to into mySQL
		$itemId = generateUuidV4()->toString();
		$item = new Item($itemId, $this->donation->getDonationId()->toSting(), $this->request->getReqeustId()->toString(),
			$this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoItem = Item::getItemByItemId($this->getPDO(), $item->getItemId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("item"));

		$this->assertEquals($pdoItem->getItemId()->toString(), $itemId);
		$this->assertEquals($pdoItem->getItemRequestId(), $this->request->getRequestId());
	}

	/**
	 * test grabing Item by Donation id
	 *
	 *
	 * @throws \Exception
	 */
	public function testGetValidItemsByItemDonationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Item");

		// create a new Item and insert to into mySQL
		$itemId = generateUuidV4()->toString();
		$item = new Item($itemId, $this->donation->getDonationId()->toSting(), $this->request->getReqeustId()->toString(),
			$this->VALID_TRACKING_NUMBER, $this->VALID_URL);
		$item->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Item::getItemsByItemDonationId($this->getPDO(), $item->getItemDonationId()->toString());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("item"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Cohort28SCP\\SoldierCarePackage\\Donation", $results);

		// grab the result from the array and validate it
		$pdoItem = $results[0];

		$this->assertEquals($pdoItem->getItemId()->toString(), $itemId);
		$this->assertEquals($pdoItem->getDonationId(), $this->request->getDonationId());
	}


}