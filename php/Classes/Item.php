<?php

namespace Cohort28SCP\SoldierCarePackage;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * @author Hannah Miltenberger <hannahmilt@gmail.com>
 *
 **/
class Item implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Item; this is the primary key
	 * @var Uuid $itemId
	 **/
	private $itemId;

	/**
	 * id of the Donation that sent this item; this is a foreign key
	 * @var Uuid $itemDonationId
	 **/

	private $itemDonationId;

	/**
	 * id of the Request that posted this item; this is a foreign key
	 * @var Uuid $itemRequestId
	 **/
	private $itemRequestId;

	/**
	 * Tracking number of sent item
	 * @var string $itemTrackingNumber
	 **/
	private $itemTrackingNumber;

	/**
	 * the Url of a website linked to this item
	 * @var string $itemUrl
	 **/
	private $itemUrl;

	/**
	 * constructor for this Item
	 *
	 * @param string|Uuid $newItemId id of this Item or null if a new Item
	 * @param string|Uuid $newItemDonationId id of the Donation that sent this item
	 * @param string|Uuid $newItemRequestId id of the Request that posted this item
	 * @param string $newItemTrackingNumber string containing newItemTrackingNumber
	 * @param string $newItemUrl string containing newItemUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newItemId, $newItemDonationId, $newItemRequestId, $newItemTrackingNumber, $newItemUrl) {
		try {
			$this->setItemId($newItemId);
			$this->setItemDonationId($newItemDonationId);
			$this->setItemRequestId($newItemRequestId);
			$this->setItemTrackingNumber($newItemTrackingNumber);
			$this->setItemUrl($newItemUrl);

			/*     catches errors or invalid inputs??  */
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception){
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/** accessor method for itemId
	 *@return Uuid of itemId
	 */

	public function getItemId() : Uuid {
		return($this->itemId);
	}

	/**
	 * mutator method for item id
	 *
	 * @param Uuid|string $newItemId new value of item id
	 * @throws \RangeException if $newItemId is not positive
	 * @throws \TypeError if $newItemId is not a uuid or string
	 **/
	public function setItemId( $newItemId) : void {
		try {
			$uuid = self::validateUuid($newItemId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->itemId = $uuid;
	}

	/** accessor method for itemDonationId
	 *@return Uuid of itemDonationId
	 */
	public function getItemDonationId() {
		return($this->itemDonationId);
	}

	/**
	 * mutator method for item donation id
	 *
	 * @param Uuid|string $newItemDonationId new value of item donation id
	 * @param \InvalidArgumentException
	 * @throws \RangeException if $newItemDonationId is not positive
	 * @throws \Exception
	 * @throws \TypeError if $newItemDonationId is not a uuid or string
	 **/
	public function setItemDonationId($newItemDonationId) : void {
		if ($newItemDonationId===null) {
			$uuid = null;
		}else{
			try {
				$uuid = self::validateUuid($newItemDonationId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}
		$this->itemDonationId = $uuid;
	}
	/** accessor method for itemRequestId
	 *@return Uuid of itemRequestId
	 */
	public function getItemRequestId() : Uuid {
		return($this->itemRequestId);
	}

	/**
	 * mutator method for item request id
	 *
	 * @param Uuid|string $newItemRequestId new value of item request id
	 * @throws \RangeException if $newItemRequestId is not positive
	 * @throws \TypeError if $newItemRequestId is not a uuid or string
	 **/
	public function setItemRequestId( $newItemRequestId) : void {
		try {
			$uuid = self::validateUuid($newItemRequestId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->itemRequestId = $uuid;
	}
	/**
	 * accessor method for item tracking number
	 *
	 * @return string value of item tracking number
	 **/
	public function getItemTrackingNumber() : string {
		return($this->itemTrackingNumber);
	}

	/**
	 * mutator method for item tracking number
	 *
	 * @param string $newItemTrackingNumber new value of item tracking number
	 * @throws \InvalidArgumentException if $newItemTrackingNumber is not a string or insecure
	 * @throws \RangeException if $newItemTrackingNumber is > 40 characters
	 * @throws \TypeError if $newItemTrackingNumber is not a string
	 **/
	public function setItemTrackingNumber( $newItemTrackingNumber) : void {
		//verify the item tracking number is secure
		$newItemTrackingNumber = trim($newItemTrackingNumber);
		$newItemTrackingNumber= filter_var($newItemTrackingNumber, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the item tracking number will fit in tbe database
		if(strlen($newItemTrackingNumber) > 40){
			throw(new\RangeException("item tracking number is too large"));
		}
		//store the item tracking number
		$this->itemTrackingNumber = $newItemTrackingNumber;
	}

	/**
	 * accessor method for item url
	 *
	 * @return string value of item url
	 **/
	public function getItemUrl() : string {
		return($this->itemUrl);
	}

	/**
	 * mutator method for item url
	 *
	 * @param string $newItemUrl new value of item url
	 * @throws \InvalidArgumentException if $newItemUrl is not a string or insecure
	 * @throws \RangeException if $newItemUrl is > 255 characters
	 * @throws \TypeError if $newItemUrl is not a string
	 **/
	public function setItemUrl( string  $newItemUrl) : void {
		//verify the item url is secure
		$newItemUrl = trim($newItemUrl);
		$newItemUrl= filter_var($newItemUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newItemUrl) === true) {
			throw(new \InvalidArgumentException("item url is empty or insecure"));
		}
		//verify the item url will fit in tbe database
		if(strlen($newItemUrl) > 255){
			throw(new\RangeException("item url is too large"));
		}
		//store the item url
		$this->itemUrl = $newItemUrl;
	}

	/**
	 * inserts this Item into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo) : void {
		//query template
		$query = "INSERT INTO item(itemId, itemDonationId, itemRequestId, itemTrackingNumber, itemUrl) 
						VALUES(:itemId, :itemDonationId, :itemRequestId, :itemTrackingNumber, :itemUrl)";

		//send the statement to PDO so it knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holders in the template
		//left out date because no date in data
		$parameters = ["itemId" => $this->itemId->getBytes(),
			"itemDonationId" =>$this->itemDonationId === null ? null : $this->itemDonationId->getBytes() ,
			"itemRequestId" => $this->itemRequestId->getBytes() ,
			"itemTrackingNumber" => $this->itemTrackingNumber,
			"itemUrl" => $this->itemUrl];

		//Execute the statement on the database
		$statement->execute($parameters);
	}

	/**
	 * updates this Item in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whn mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
//	public function update(\PDO $pdo) : void {
//
//		//create query template
//		$query = "UPDATE item
//					SET itemId = :itemId, itemDonationId = :itemDonationId, itemRequestId = :itemRequestId, itemTrackingNumber = :itemTrackingNumber, itemUrl = :itemUrl
//					WHERE itemId = :itemId";
//
//		//prepare a statement using the SQL so PDO knows what to do.
//		$statement = $pdo->prepare($query);
//
//		// bind the member variables to the place holders in in the template
//		$parameters = ["itemId" => $this->itemId->getBytes(),
//			"itemDonationId" => $this->itemDonationId->getBytes(),
//			"itemRequestId" => $this->itemRequestId->getBytes(),
//			"itemTrackingNumber" => $this->itemTrackingNumber,
//			"itemUrl" => $this->itemUrl];
//
//		//now execute he statement on the database
//		$statement->execute($parameters);
//	}

	/**
	 * deletes this item from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError is $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM item WHERE itemId = :itemId";

		//prepare a statement object using the SQL so pdo knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["itemId" => $this->itemId->getBytes()];

		//now execute the statement on the database.
		$statement->execute($parameters);
	}

	/**
	 * get the Item by ItemId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $itemId item id to search for
	 * @return Item|null Item found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getItemByItemId(\PDO $pdo, $itemId) : ?Item {
		//sanitize the itemId before searching
		try {
			$itemId = self::validateUuid($itemId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT itemId, itemDonationId, itemRequestId, itemTrackingNumber, itemUrl FROM item WHERE itemId = :itemId";
		$statement = $pdo->prepare($query);

		//bing the item id to the place holder in the template
		$parameters = ["itemId" => $itemId->getBytes()];
		$statement->execute($parameters);


		//grab the item from mySQL
		try {
			$item = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$item = new Item($row["itemId"], $row["itemDonationId"], $row["itemRequestId"], $row["itemTrackingNumber"], $row["itemUrl"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($item);
	}

	/**
	 * gets the items by request id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $itemRequestId request id to search by
	 * @return \SplFixedArray SplFixedArray of Items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemsByItemRequestId(\PDO $pdo, $itemRequestId) : \SplFixedArray {

		try {
			$itemRequestId = self::validateUuid($itemRequestId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT itemId, itemDonationId, itemRequestId, itemTrackingNumber, itemUrl FROM item WHERE itemRequestId = :itemRequestId";
		$statement = $pdo->prepare($query);
		// bind the item request id to the place holder in the template
		$parameters = ["itemRequestId" => $itemRequestId->getBytes()];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new item($row["itemId"], $row["itemDonationId"], $row["itemRequestId"], $row["itemTrackingNumber"], $row["itemUrl"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($items);
	}

	/**
	 * gets the Item by donation id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $itemDonationId doantion id to search by
	 * @return \SplFixedArray SplFixedArray of items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getItemsByItemDonationId(\PDO $pdo, $itemDonationId) : \SplFixedArray {

		try {
			$itemDonationId = self::validateUuid($itemDonationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT itemId, itemDonationId, itemRequestId, itemTrackingNumber, itemUrl FROM item WHERE itemDonationId = :itemDonationId";
		$statement = $pdo->prepare($query);
		// bind the item donation id to the place holder in the template
		$parameters = ["itemDonationId" => $itemDonationId->getBytes()];
		$statement->execute($parameters);
		// build an array of items
		$items = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$item = new Item($row["itemId"], $row["itemDonationId"], $row["itemRequestId"], $row["itemTrackingNumber"], $row["itemUrl"]);
				$items[$items->key()] = $item;
				$items->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($items);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["itemId"] = $this->itemId->toString();
		$fields["itemDonationId"] =$this->itemDonationId === null ? null : $this->itemDonationId->toString();
		$fields["itemRequestId"] = $this->itemRequestId->toString();
		return($fields);
	}
}
