<?php

namespace Cohort28SCP\SoldierCarePackage;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use InvalidArgumentException\RangeException\Exception\TypeError;
use Ramsey\Uuid;
/**
 * Classes for the profile table
 *
 * This is the code for the classes and methods for the profile table
 *
 * @author Nohemi Tarango <ntarango3@cnm.edu>
 **/
class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 *  id for this profile; this is the primary key
	 **/
	private $profileId;
	/**
	 * activation token for the profile; the activation token contains information that is used to identify a user
	 **/
	private $profileActivationToken;
	/**
	 *  the address of the soldier; where the soldier is stationed
	 **/
	private $profileAddress;
	/**
	 *  the avatar url for the profile; the small image that identifies the profile
	 **/
	private $profileAvatarUrl;
	/**
	 * the bio for the profile; the user will write about themselves
	 **/
	private $profileBio;
	/**
	 * the city for the profile; the city where the soldier is currently stationed
	 **/
	private $profileCity;
	/**
	 *  the email of the profile; where the user of the profile can be contacted
	 **/
	private $profileEmail;
	/**
	 *  the hash of the profile; hash codes retrieve data from hash based collections
	 **/
	private $profileHash;
	/**
	 *  the name of the soldier for the profile; the users full name used for shipping information
	 **/
	private $profileName;
	/**
	 *  the rank of the soldier for the profile; the users rank is used for shipping information
	 **/
	private $profileRank;
	/**
	 *  the state where the soldier is stationed, the state is used for shipping information
	 **/
	private $profileState;
	/**
	 *  the type of profile; the type will either be the soldier or the sender
	 **/
	private $profileType;
	/**
	 *  the username in the profile; the user will make a username for the profile
	 **/
	private $profileUsername;
	/**
	 *  the zip code where the soldier is stationed; the zip is used for shipping information
	 **/
	private $profileZip;

	/**
	 * constructor for this profile
	 *
	 * @param Uuid $newProfileId new profile id
	 * @param string $newProfileActivationToken new profile activation token
	 * @param string $newProfileAddress new profile address
	 * @param string $newProfileAvatarUrl new profile avatar url
	 * @param string $newProfileBio new profile bio
	 * @param string $newProfileCity new profile city
	 * @param string $newProfileEmail new profile email
	 * @param string $newProfileHash new profile hash
	 * @param string $newProfileName new profile name
	 * @param string $newProfileRank new profile rank
	 * @param string $newProfileState new profile state
	 * @param string $newProfileType new profile type
	 * @param string $newProfileUsername new profile username
	 * @param string $newProfileZip new profile zip
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct($newProfileId, $newProfileActivationToken, $newProfileAddress, $newProfileAvatarUrl, $newProfileBio, $newProfileCity, $newProfileEmail, $newProfileHash, $newProfileName, $newProfileRank, $newProfileState, $newProfileType, $newProfileUsername, $newProfileZip) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAddress($newProfileAddress);
			$this->setProfileAvatarUrl($newProfileAvatarUrl);
			$this->setProfileBio($newProfileBio);
			$this->setProfileCity($newProfileCity);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileName($newProfileName);
			$this->setProfileRank($newProfileRank);
			$this->setProfileState($newProfileState);
			$this->setProfileType($newProfileType);
			$this->setProfileUsername($newProfileUsername);
			$this->setProfileZip($newProfileZip);
		} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *  accesor method for profile id
	 *
	 * @return uuid value of profile id or null of new Profile
	 **/
	public function getProfileId() : uuid {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid| string $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if the profile Id is not valid
	 **/
	public function setProfileId($newProfileId) : void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the profile id
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for the profile activation token
	 *
	 * @return string value of profile activation token
	 **/
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken new value of the profile activation token
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/
	public function setProfileActivationToken(?string $newProfileActivationToken) : void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		//verify the profile activation token is valid
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation token is not valid"));
		}

		// make sure the profile activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile address
	 *
	 * @return string value of profile address
	 **/
	public function getProfileAddress() : string {
		return ($this->profileAddress);
	}

	/**
	 * mutator method for profile address
	 *
	 * @param string $newProfileAddress
	 * @throws \InvalidArgumentException if $newProfileAddress is not a string or insecure
	 * @throws \RangeException if $newProfileAddress is > 32 characters
	 * @throws \TypeError if $newProfileAddress is not a string
	 **/
	public function setProfileAddress(string $newProfileAddress) : void {
		//verify the profile address is secure
		$newProfileAddress = trim($newProfileAddress);
		$newProfileAddress = filter_var($newProfileAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddress) === true) {
			throw(new \InvalidArgumentException("profile address is empty or insecure"));
		}

		//verify the profile address will fit in the database
		if(strlen($newProfileAddress) > 32) {
			throw(new \RangeException("profile address is too large"));
		}

		//store the profile address
		$this->profileAddress = $newProfileAddress;
	}

	/**
	 * accessor method for profile avatar url
	 *
	 * @return string value of the avatar url
	 **/
	public function getProfileAvatarUrl() : string {
		return ($this->profileAvatarUrl);
	}

	/**
	 * mutator method for profile avatar url
	 *
	 * @param string $newProfileAvatarUrl new value of profile avatar url
	 * @throws \InvalidArgumentException if $newProfileAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newProfileAvatarUrl is > 255 characters
	 * @throws \TypeError if $newProfileAvatarUrl is not a string
	 **/
	public function setProfileAvatarUrl(string $newProfileAvatarUrl) : void {
		$newProfileAvatarUrl = trim($newProfileAvatarUrl);
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify the profile avatar url will fit in the database
		if(strlen($newProfileAvatarUrl) > 255) {
			throw(new \RangeException("image cloudinary content too large"));
		}

		//store the image cloudinary content
		$this->profileAvatarUrl = $newProfileAvatarUrl;
	}

	/**
	 * accessor method for profile bio
	 *
	 * @return string value of profile bio
	 **/
	public function getProfileBio() : string {
		return ($this->profileBio);
	}

	/**
	 * mutator method for the profile bio
	 *
	 * @param string $newProfileBio new value of profile bio
	 * @throws \InvalidArgumentException if $newProfileBio is not a string or insecure
	 * @throws \RangeException if $newProfileBio is > 500 characters
	 * @throws \TypeError if $newProfileBio is not a string
	 **/
	public function setProfileBio(string $newProfileBio) : void {
		//verify the profile bio is secure
		$newProfileBio = trim($newProfileBio);
		$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileBio) === true) {
			throw(new \InvalidArgumentException("profile bio is empty or insecure"));
		}

		// verify the profile bio will fit in the database
		if(strlen($newProfileBio) > 500) {
			throw(new \RangeException("profile bio is too large"));
		}

		// store the profile bio
		$this->profileBio = $newProfileBio;
	}

	/**
	 * accessor method for profile city
	 *
	 * @return string value of profile city
	 **/
	public function getProfileCity() : string {
		return ($this->profileCity);
	}

	/**
	 * mutator method for the profile city
	 *
	 * @param string $newProfileCity new value of profile city
	 * @throws \InvalidArgumentException if $newProfileCity is not a string or insecure
	 * @throws \RangeException if $newProfileCity is > 3 characters
	 * @throws \TypeError if $newProfileCity is not a string
	 **/
	public function setProfileCity(string $newProfileCity) : void {
		// verify the profile city is secure
		$newProfileCity = trim($newProfileCity);
		$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileCity) === true) {
			throw(new \InvalidArgumentException("profile city is empty or insecure"));
		}

		// verify the profile city will fit in the database
		if(strlen($newProfileCity) > 3) {
			throw(new \RangeException("profile city is too large"));
		}

		// store the profile city
		$this->profileCity = $newProfileCity;
	}

	/**
	 * accesor method for profile Email
	 *
	 * @return string value of profile email
	 **/
	public function getProfileEmail() : string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is not a valid email or insecure
	 * @throws \RangeException if $newProfileEmail is > 128 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) : void {
		//verify the profile email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}

		// verify the profile email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}

		//store the profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
	 **/
	public function getProfileHash() : string {
		return $this->profileHash;
	}

	/**
	 * mutator method for the profile hash
	 *
	 * @param string $newProfileHash new value of hash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if the profile hash is not a string
	 **/
	public function setProfileHash(string $newProfileHash) : void {
		// enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}

		// enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}

		// enforce that the hash is exactly 97 characters
		if(strlen($newProfileHash) > 97) {
			throw(new \RangeException("profile hash is too large"));
		}

		//store the profile hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accesor method for profile name
	 *
	 * @return string value of profile name
	 **/
	public function getProfileName() : string {
		return ($this->profileName);
	}

	/**
	 * mutator method for the profile name
	 *
	 * @param string $newProfileName new value of profile name
	 * @throws \InvalidArgumentException if $newProfileName is not a string or insecure
	 * @throws \RangeException if $newProfileName is > 100 characters
	 * @throws \TypeError if $newProfileName is not a string
	 **/
	public function setProfileName(string $newProfileName) : void {
		//verify the profile name is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("profile name is empty or insecure"));
		}

		// verify the profile name will fit in the database
		if(strlen($newProfileName) > 100) {
			throw(new \RangeException("profile name is too large"));
		}

		//store the profile name
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile rank
	 *
	 * @return string value of profile rank
	 **/
	public function getProfileRank() : string {
		return ($this->profileRank);
	}

	/**
	 * mutator method for the profile rank
	 *
	 * @param string $newProfileRank new value of profile rank
	 * @throws \InvalidArgumentException if $newProfileRank is not a string or insecure
	 * @throws \RangeException if $newProfileRank is > 32 characters
	 * @throws \TypeError if $newProfileRank is not a string
	 **/
	public function setProfileRank(string $newProfileRank) : void {
		//verify the profile rank is secure
		$newProfileRank = trim($newProfileRank);
		$newProfileRank = filter_var($newProfileRank, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileRank) === true) {
			throw(new \InvalidArgumentException("profile rank is empty or insecure"));
		}

		// verify the profile rank will fit in the database
		if(strlen($newProfileRank) > 32) {
			throw(new \RangeException("profile rank is too large"));
		}

		//store the profile rank
		$this->profileRank = $newProfileRank;
	}

	/**
	 *accessor method for profile state
	 *
	 * @return string value of profile state
	 **/
	public function getProfileState() : string {
		return ($this->profileState);
	}

	/**
	 * mutator method for the profile state
	 *
	 * @param string $newProfileState new value of profile state
	 * @throws \InvalidArgumentException if $newProfileState is not a string or insecure
	 * @throws \RangeException if $newProfileState is > 2 characters
	 * @throws \TypeError if $newProfileState is not a string
	 **/
	public function setProfileState(string $newProfileState) : void {
		//verify the profile state is secure
		$newProfileState = trim($newProfileState);
		$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileState) === true) {
			throw(new \InvalidArgumentException("profile state is empty or insecure"));
		}

		// verify the profile state will fit in the database
		if(strlen($newProfileState) > 2) {
			throw(new \RangeException("profile state is too large"));
		}

		// store the profile state
		$this->profileState = $newProfileState;
	}

	/**
	 * accessor method for profile type
	 *
	 * @return string value of profile type
	 **/
	public function getProfileType() : string {
		return ($this->profileType);
	}

	/**
	 * mutator method for the profile type
	 *
	 * @param string $newProfileType new value of profile type
	 * @throws \InvalidArgumentException if $newProfileType is not a string or insecure
	 * @throws \RangeException if $newProfileType is > 15 characters
	 * @throws \TypeError if $newProfileType is not a string
	 **/
	public function setProfileType(string $newProfileType) : void {
		//verify the profile type is secure
		$newProfileType = trim($newProfileType);
		$newProfileType = filter_var($newProfileType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileType) === true) {
			throw(new \InvalidArgumentException("profile type is empty or insecure"));
		}

		// verify the profile type will fit in the database
		if(strlen($newProfileType) > 15) {
			throw(new \RangeException("profile type is too large"));
		}

		// store the profile type
		$this->profileType = $newProfileType;
	}

	/**
	 * accessor method for profile username
	 *
	 * @return string value of profile username
	 **/
	public function getProfileUsername() : string {
		return ($this->profileUsername);
	}

	/**
	 * mutator method for the profile username
	 *
	 * @param string $newProfileUsername new value of profile username
	 * @throws \InvalidArgumentException if $newProfileUsername is not a string or insecure
	 * @throws \RangeException if $newProfileUsername is > 32 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 **/
	public function setProfileUsername(string $newProfileUsername) : void {
		// verify the profile username is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUsername) === true) {
			throw(new \InvalidArgumentException("profile username is empty or insecure"));
		}

		// verify the profile username will fit in the database
		if(strlen($newProfileUsername) > 32) {
			throw(new \RangeException("profile username is too large"));
		}

		//store the profile username
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * accessor method for profile zip
	 *
	 * @return string value of profile zip
	 **/
	public function getProfileZip() : string {
		return ($this->profileUsername);
	}

	/**
	 * mutator method for the profile zip
	 *
	 * @param string $newProfileZip new value of profile zip
	 * @throws \InvalidArgumentException if $newProfileZip is not a string or insecure
	 * @throws \RangeException if $newProfileZip is > 5 to 9 characters
	 * @throws \TypeError if $newProfileZip is not a string
	 **/
	public function setProfileZip(string $newProfileZip) : void {
		//verify the profile zip is secure
		$newProfileZip = trim($newProfileZip);
		$newProfileZip = filter_var($newProfileZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileZip) === true) {
			throw(new \InvalidArgumentException("profile zip is empty or insecure"));
		}

		// verify the profile zip will fit in the database
		if(strlen($newProfileZip) > 9) {
			throw(new \RangeException("profile zip is too large"));
		}

		//store the profile zip
		$this->profileZip = $newProfileZip;
	}

	/**
	 * insert this profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		//create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAddress, profileAvatarUrl, profileBio, profileCity, profileEmail, profileHash, profileName, profileRank, profileState, profileType, profileUsername, profileZip)
					VALUES(:profileId, :profileActivationToken, :profileAddress, :profileAvatarUrl, :profileBio, :profileCity, :profileEmail, :profileHash, :profileName, :profileRank, :profileState, :profileType, :profileUsername, :profileZip)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken,
			"profileAddress" => $this->profileAddress, "profileAvatarUrl" => $this->profileAvatarUrl,
			"profileBio" => $this->profileBio, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail,
			"profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileRank" => $this->profileRank,
			"profileState" => $this->profileState, "profileType" => $this->profileType,
			"profileUsername" => $this->profileUsername, "profileZip" => $this->profileZip];
		$statement->execute($parameters);
	}

	/**
	 * update this profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, profileAddress = :profileAddress, profileAvatarUrl = :profileAvatarUrl, profileBio = :profileBio, profileCity = :profileCity, profileEmail = :profileEmail, profileHash = :profileHash, profileName = :profileName, profileRank =:profileRank, profileState = :profileState, profileType =:profileType, profileUsername =:profileUsername, profileZip = :profileZip
						WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAddress" => $this->profileAddress, "profileAvatarUrl" => $this->profileAvatarUrl, "profileBio" => $this->profileBio, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileRank" => $this->profileRank, "profileState" => $this->profileState, "profileType" => $this->profileType, "profileUsername" => $this->profileUsername, "profileZip" => $this->profileZip];
		$statement->execute($parameters);
	}

	/**
	 * delete this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		//create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * get the profile by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| string $profileId profile id to search for
	 * @return profile|null profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?profile {
		// sanitize the profileId before searching
		try{
			$profileId = self::validateUuid($profileId);
		} catch(InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAddress, profileAvatarUrl, profileBio, profileCity, profileEmail, profileHash, profileName, profileRank, profileState, profileType, profileUsername, profileZip
						FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAddress"],
					$row["profileAvatarUrl"], $row["profileBio"], $row["profileCity"], $row["profileEmail"],
					$row["profileHash"], $row["profileName"], $row["profileRank"], $row["profileState"],
					$row["profileType"], $row["profileUsername"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * get all soldier profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of profile found or null of not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllSoldierProfiles(\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT FROM profile: profileId, profileActivationToken, profileAddress, profileAvatarUrl, profileBio, profileCity, profileEmail, profileHash, profileName, profileRank, profileState, profileType, profileUsername, profileZip
						WHERE profileType = :soldierProfile";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of soldier profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAddress"], $row["profileAvatarUrl"], $row["profileBio"], $row["profileCity"], $row["profileEmail"], $row["profileHash"], $row["profileName"], $row["profileRank"], $row["profileState"], $row["profileType"], $row["profileUsername"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		unset($fields["profileActivationToken"]);
		unset($fields["profileHash"]);
		return($fields);
	}
}
