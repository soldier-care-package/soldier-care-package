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
}