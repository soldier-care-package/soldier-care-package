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
class Request implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this Request; this is the primary key
	 * @var Uuid $requestId
	 **/
	private $requestId;

	/** id of the Profile that is Requesting; this is a foreign key
	 *@var Uuid $requestProfileId
	 **/
	private $requestProfileId;

	/**
	 * actual textual content of this Request
	 * @var string $requestContent
	 **/
	private $requestContent;

	/** date and time this request was made, in a PHP DateTime object
	 *@var \DateTime $requestDate
	 */
	private $requestDate;

	/**
	 * constructor for this Request
	 *
	 * @param string|Uuid $newRequestId id of this Request or null if a new Request
	 * @param string|Uuid $newRequestProfileId id of the Profile that sent this Request
	 * @param string $newRequestContent string containing actual request data
	 * @param \DateTime|string|null $newRequestDate date and time Request was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newRequestId, $newRequestProfileId, $newRequestContent, $newRequestDate = null) {
		try {
			$this->setRequestId($newRequestId);
			$this->setRequestProfileId($newRequestProfileId);
			$this->setRequstContent($newRequestContent);
			$this->setRequestDate($newRequestDate);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**  accessor method for Request id
	 *
	 * @return Uuid value of Request id
	 **/
	public function getRequestId() : Uuid {
		return($this->requestId);
	}

	/**
	 * mutator method for donation id
	 *
	 * @param Uuid|string $newDonationId new value of donation id
	 * @throws \RangeException if $newDonationId is not positive
	 * @throws \TypeError if $newDonationId is not a uuid or string
	 **/
	public function setDonationId( $newDonationId) : void {
		try {
			$uuid = self::validateUuid($newDonationId);
		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the profile id
		$this->DonationId = $uuid;

	}
}