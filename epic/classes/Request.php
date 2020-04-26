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
	 * mutator method for request id
	 *
	 * @param Uuid|string $newRequestId new value of request id
	 * @throws \RangeException if $newRequestId is not positive
	 * @throws \TypeError if $newRequestId is not a uuid or string
	 **/
	public function setRequestId( $newRequestId) : void {
		try {
			$uuid = self::validateUuid($newRequestId);
		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the request id
		$this->RequestId = $uuid;
	}

	/**
	 * accessor method for request profile id
	 * @return Uuid value of request profile id
	 */
	public function getRequestProfileId() : Uuid {
		return($this->requestProfileId);
	}

	/**
	 * mutator method for request profile id
	 *
	 * @param Uuid|string $newRequestProfileId new value of request profile id
	 * @throws \RangeException if $newRequestProfileId is not positive
	 * @throws \TypeError if $newRequestProfileId is not a uuid or string
	 **/
	public function setRequestProfileId( $newRequestProfileId) : void {
		try {
			$uuid = self::validateUuid($newRequestProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(),0, $exception));
		}
		$this->requestProfileId = $uuid;
	}

	/**
	 * accessor method for request content
	 *
	 * @return string value of request content
	 **/
	public function getRequestContent() : string {
		return($this->requestContent);
	}

	/**
	 * mutator method for request content
	 *
	 * @param string $newRequestContent new value of request content
	 * @throws \InvalidArgumentException if $newRequestContent is not a string or insecure
	 * @throws \RangeException if $newRequestContent is > 500 characters
	 * @throws \TypeError if $newRequestContent is not a string
	 **/
	public function setRequestContent(string $newRequestContent) : void {
		// verify the request content is secure
		$newRequestContent = trim($newRequestContent);
		$newRequestContent = filter_var($newRequestContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRequestContent) === true) {
			throw(new \InvalidArgumentException("request content is empty or insecure"));
		}

		// verify the request content will fit in the database
		if(strlen($newRequestContent) > 500) {
			throw(new \RangeException("request content too large"));
		}

		// store the request content
		$this->requestContent = $newRequestContent;
	}

	/**
	 * accessor method for request date
	 *
	 * @return \DateTime value of request date
	 **/
	public function  getRequestDate() :\DateTime {
		return($this->requestDate);
	}

	/**
	 * mutator method for request date
	 *
	 * @param \DateTime|string|null $newRequestDate request date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newRequestDate is not a valid object or string
	 * @throws \RangeException if $newRequestDate is a date that does not exist
	 **/

	public function setRequestDate($newRequestDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newRequestDate === null) {
			$this->RequestDate = new \DateTime();
			return;
		}

		// store the request date using the ValidateDate trait
		try {
			$newRequestDate = self::validateDateTime($newRequestDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->requestDate = $newRequestDate;
	}

	/**
	 * inserts this Request into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//query template
		$query = "INSERT INTO request(requestId, requestProfileId, requestContent, requestDate) VALUES(:requestId, :requestProfileId, :requestDate)";

		//send the statement to PDO so it knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holders in the template
		$formattedDate = $this->requestDate->format("Y-m-d H:i:s.u");
		$parameters = ["requestId" => $this->requestId->getBytes(),
			"requestProfileId" => $this->requestProfileId->getBytes(),
			"requestContent" => $this->requestContent,
			"requestDate" => $formattedDate];

		//Execute the statement on the database
		$statement->execute($parameters);
	}

	/**
	 * updates this Request in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whn mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		//create query template
		$query = "UPDATE request
					SET requestId = :requestId, requestProfileId = :requestProfileId, requestContent = :requestContent, requestDate = :requestDate
					WHERE requestId = :requestId";

		//prepare a statement using the SQL so PDO knows what to do.
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in in the template
		$formattedDate = $this->requestDate->format("Y-m-d H:i:s.u");
		$parameters = ["requestId" => $this->requestId->getBytes(),
			"requestProfileId" => $this->requestProfileId->getBytes(),
			"requestContent" => $this->requestContent,
			"requestDate" => $formattedDate];

		//now execute he statement on the database
		$statement->execute($parameters);
	}

	/**
	 * deletes this Request from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM request WHERE requestId = :requestId";

		//prepare a statement object using the SQL so pdo knows what to do.
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["requestId" => $this->requestId->getBytes()];

		//now execute the statement on the database.
		$statement->execute($parameters);
	}





}