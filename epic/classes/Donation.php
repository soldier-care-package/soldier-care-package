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
class Donation implements \JsonSerializable {
	use ValiateDate;
	use ValidateUuid;
	/** id for Donation; this is the primary key
	 *@var Uuid $donationId
	 **/
	private $donationId;
	/** id of the Profile that is Donating; this is a foreign key
	 *@var Uuid $donationProfileId
	 **/
	private $donationProfileId;
	/** date and time this donation was accepted, in a PHP DateTime object
	 *@var \DateTime $donationDate
	 */
	private $donationDate;

	/** constructor for this Donation
	 *
	 *@param string|Uuid $newDonationId id of this Donation or null if a new Donation
	 *@param string|Uuid $newDonationProfileId id of the Profile that Accepted this Donation
	 *@para \DateTime|string|null $newDonationDate date and time Donation was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newDonationId, $newDonationProfileId, $newDonationDate = null) {
		try {
				$this->setDonationId($newDonationId);
				$this->setDonationProfileId($newDonationProfileId);
				$this->setDonationDate($newDonationDate);
		}
		//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

	}
	/**  accessor method for Donation id
	 *
	 * @return Uuid value of Donation id
	 **/
	public function getDonationId() : Uuid {
		return($this->donationId);
	}

	/**
	 * mutator method for donation id
	 *
	 * @param Uuid|string $newDonationId new value of donation id
	 * @throws \RangeException if $newDonationId is not positive
	 * @throws \TypeError if $newDonationId is not a uuid or string
	 **/
}