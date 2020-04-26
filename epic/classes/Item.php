<?php

namespace Soldier_Care_Package\Soldier_Care_Package;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * Small Cross Section of a Twitter like Message
 *
 * This Tweet can be considered a small example of what services like Twitter store when messages are sent and
 * received using Twitter. This can easily be extended to emulate more features of Twitter.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 3.0.0
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
	public function getItemDonationId() : Uuid {
		return($this->itemDonationId);
	}

	/**
	 * mutator method for item donation id
	 *
	 * @param Uuid|string $newItemDonationId new value of item donation id
	 * @throws \RangeException if $newItemDonationId is not positive
	 * @throws \TypeError if $newItemDonationId is not a uuid or string
	 **/
	public function setItemDonationId( $newItemDonationId) : void {
		try {
			$uuid = self::validateUuid($newItemDonationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
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
	public function setItemTrackingNumber( string  $newItemTrackingNumber) : void {
		//verify the item tracking number is secure
		$newItemTrackingNumber = trim($newItemTrackingNumber);
		$newItemTrackingNumber= filter_var($newItemTrackingNumber, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newItemTrackingNumber) === true) {
			throw(new \InvalidArgumentException("item tracking number is empty or insecure"));
		}
		//verify the item tracking number will fit in tbe database
		if(strlen($newItemTrackingNumber) > 255){
			throw(new\RangeException("item tracking number is too large"));
		}
		//store the item tracking number
		$this->itemTrackingNumber = $newItemTrackingNumber;
	}





}
