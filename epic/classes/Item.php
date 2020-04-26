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
	/** accessor method for authorId
	 *@return Uuid of authorId
	 */

	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

}
