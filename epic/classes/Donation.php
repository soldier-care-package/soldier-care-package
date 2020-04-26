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
	 *@param  \DateTime|string|null $newDonationDate date and time Donation was sent or null if set to current date and time
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
	public function setDonationId( $newDonationId) : void {
		try {
			$uuid = self::validateUuid($newDonationId);
		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the request id
		$this->DonationId = $uuid;

	}
	/**
	 * accessor method for donation profile id
	 * @return Uuid value of donation profile id
	 */
	public function getDonationProfileId() : Uuid {
		return($this->donationProfileId);
	}

	/**
	 * mutator method for donation profile id
	 *
	 * @param Uuid|string $newDonationProfileId new value of donation profile id
	 * @throws \RangeException if $newDonationProfileId is not positive
	 * @throws \TypeError if $newDonationProfileId is not a uuid or string
	 **/
	public function setDonationProfileId( $newDonationProfileId) : void {
		try {
			$uuid = self::validateUuid($newDonationProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->donationProfileId = $uuid;
	}

	/**
	 * accessor method for donation date
	 *
	 * @return \DateTime value of donation date
	 **/
	public function  getDonationDate() :\DateTime {
		return($this->donationDate);
	}

	/**
	 * mutator method for donation date
	 *
	 * @param \DateTime|string|null $newDonationDate donation date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newDonationDate is not a valid object or string
	 * @throws \RangeException if $newDonationDate is a date that does not exist
	 **/

	public function setDonationDate($newDonationDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newDonationDate === null) {
			$this->DonationDate = new \DateTime();
			return;
		}

		// store the donation date using the ValidateDate trait
		try {
			$newDonationDate = self::validateDateTime($newDonationDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->donationDate = $newDonationDate;
	}

	/**
	 * inserts this Donation into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//query template
		$query = "INSERT INTO donation(donationId, donationProfileId, donationDate) VALUES(:donationId, :donationProfileId, :donationDate)";

		//send the statement to PDO so it knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holders in the template
		$formattedDate = $this->donationDate->format("Y-m-d H:i:s.u");
		$parameters = ["donationId" => $this->donationId->getBytes(),
			"donationProfileId" => $this->donationProfileId->getBytes(),
			"donationDate" => $formattedDate];

		//Execute the statement on the database
		$statement->execute($parameters);
	}

	/**
	 * updates this Donation in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whn mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		//create query template
		$query = "UPDATE donation
					SET donationId = :donationId, donationProfileId = :donationProfileId, donationDate = :donationDate
					WHERE donationId = :donationId";

		//prepare a statement using the SQL so PDO knows what to do.
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in in the template
		$formattedDate = $this->donationDate->format("Y-m-d H:i:s.u");
		$parameters = ["donationId" => $this->donationId->getBytes(),
			"donationProfileId" => $this->donationProfileId->getBytes(),
			"donationDate" => $formattedDate];

		//now execute he statement on the database
		$statement->execute($parameters);
	}

	/**
	 * deletes this Donation from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM donation WHERE donationId = :donationId";

		//prepare a statement object using the SQL so pdo knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["donationId" => $this->donationId->getBytes()];

		//now execute the statement on the database.
		$statement->execute($parameters);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["donationId"] = $this->donationId->toString();
		unset($fields["donationProfileId"]);

		//format the date so that the front end can consume it
		$fields["donationDate"] = round(floatval($this->donationDate->format("U.u")) * 1000);
		return($fields);
	}

}