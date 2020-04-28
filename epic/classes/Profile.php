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
class Profile {
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
	 *  the zipcode where the soldier is stationed; the zip is used for shipping information
	 **/

	/**
	 * constructor for this profile
	 *
	 * @param uuid $newProfileId new profile id
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
	 * @throws UnexpectedValueException if any of the parameters are invalid
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

			//determine what exception type was thrown
		} catch(TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *  accesor method for profile id
	 *
	 * @return uuid value of profile id
	 **/
	public function getProfileId() {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param uuid $newProfileId new value of profile id
	 * @throws UnexpectedValueException if $newProfileId is not an integar
	 **/
	public function setProfileId($newProfileId) : void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(TypeError $exception) {
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
	public function getProfileActivationToken() {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken new value of the profile activation token
	 * @throws UnexpectedValueException if $newProfileActivationToken is not valid
	 **/
	public function setProfileActivationToken($newProfileActivationToken) {
		//verify the profile activation token is valid
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING);
		if($newProfileActivationToken === false) {
			throw(new UnexpectedValueException("profile activation token is not a valid string"));
		}

		// store the profile activation token
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile address
	 *
	 * @return string value of profile address
	 **/
	public function getProfileAddress() {
		return ($this->profileAddress);
	}

	/**
	 * mutator method for profile address
	 *
	 * @param string $newProfileAddress
	 * @throws UnexpectedValueException if $newProfileAddress is not valid
	 **/
	public function setProfileAddress($newProfileAddress) {
		//verify the profile address is valid
		$newProfileAddress = filter_var($newProfileAddress, FILTER_SANITIZE_STRING);
		if($newProfileAddress === false) {
			throw(new UnexpectedValueException("profile address is not a valid string"));
		}

		//store the profile address
		$this->profileAddress = $newProfileAddress;
	}

	/**
	 * accessor method for profile avatar url
	 **/
	public function getProfileAvatarUrl() {
		return ($this->profileAvatarUrl);
	}

	/**
	 * mutator method for profile avatar url
	 *
	 * @param string $newProfileAvatarUrl
	 * @throws UnexpectedValueException if $newProfileAvatarUrl is not valid
	 **/
	public function setProfileAvatarUrl($newProfileAvatarUrl) {
		//verify the profile avatar url is valid
		$newProfileAvatarUrl = filter_var($newProfileAvatarUrl, FILTER_SANITIZE_STRING);
		if($newProfileAvatarUrl === false) {
			throw(new UnexpectedValueException("profile avatar url is not a valid string"));
		}
	}

		/**
		 * accessor method for profile bio
		 *
		 * @return string value of profile bio
		 **/
		public function getProfileBio() {
			return ($this->profileBio);
		}

		/**
		 * mutator method for the profile bio
		 *
		 * @param string $newProfileBio new value of profile bio
		 * @throws UnexpectedValueException if $newProfileBio is not valid
		 **/
		public function setProfileBio ($newProfileBio) {
			//verify the profile bio is valid
			$newProfileBio = filter_var($newProfileBio, FILTER_SANITIZE_STRING);
			if($newProfileBio === false) {
				throw(new UnexpectedValueException("profile bio is not a valid string"));
			}

			// store the profile bio
			$this->profileBio = $newProfileBio;
		}

		/**
		 * accessor method for profile city
		 *
		 * @return string value of profile city
		 **/
		public function getProfileCity() {
			return ($this->profileCity);
		}

		/**
		 * mutator method for the profile city
		 *
		 * @param string $newProfileCity new value of profile city
		 * @throws UnexpectedValueException if $newProfileCity is not valid
		 **/
		public function setProfileCity($newProfileCity) {
			// verify the profile city is valid
			$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING);
			if($newProfileCity === false) {
				throw(new UnexpectedValueException("profile city is not a valid string"));
			}

			// store the profile city
			$this->profileCity = $newProfileCity;
		}

		/**
		 * accesor method for profile Email
		 *
		 * @return string value of profile email
		 **/
		public function getProfileEmail() {
			return ($this->profileEmail);
		}

		/**
		 * mutator method for profile email
		 *
		 * @param string $newProfileEmail new value of profile email
		 * @throws UnexpectedValueException if $newProfileEmail is not valid
		 **/
		public function setProfileEmail($newProfileEmail) {
			//verify the profile email is valid
			$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
			if($newProfileEmail === false) {
				throw(new UnexpectedValueException("profile email is not a valid string"));
			}

			//store the profile email
			$this->profileEmail = $newProfileEmail;
		}

		/**
		 * accessor method for profile hash
		 *
		 * @param string value of profile hash
		 **/
		public function getProfileHash() {
			return ($this->profileHash);
		}

		/**
		 * mutator method for the profile hash
		 *
		 * @param string $newProfileHash new value of hash
		 * @throws UnexpectedValueException if $newProfileHash is not valid
		 **/
		public function setProfileHash($newProfileHash) {
			//verify the profile hash is valid
			$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING);
			if($newProfileHash === false) {
				throw(new UnexpectedValueException("profile hash is not a valid string"));
			}

			//store the profile hash
			$this->profileHash = $newProfileHash;
		}

		/**
		 * accesor method for profile name
		 *
		 * @return string value of profile name
		 **/
		public function getProfileName() {
			return ($this->profileName);
		}

		/**
		 * mutator method for the profile name
		 *
		 * @param string $newProfileName new value of profile name
		 * @throws UnexpectedValueException if $newProfileName is not valid
		 **/
		public function setProfileName($newProfileName) {
			//verify the profile name is valid
			$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
			if($newProfileName === false) {
				throw(new UnexpectedValueException("profile name is not a valid string"));
			}

			//store the profile name
			$this->profileName = $newProfileName;
		}

		/**
		 * accessor method for profile rank
		 *
		 * @return string value of profile rank
		 **/
		public function getProfileRank() {
			return ($this->profileRank);
		}

		/**
		 * mutator method for the profile rank
		 *
		 * @param string $newProfileRank new value of profile rank
		 * @throws UnexpectedValueException if $newProfileRank is not valid
		 **/
		public function setProfileRank($newProfileRank) {
			//verify the profile rank is valid
			$newProfileRank = filter_var($newProfileRank, FILTER_SANITIZE_STRING);
			if($newProfileRank === false) {
				throw(new UnexpectedValueException("profile rank is not a valid string"));
			}

			//store the profile rank
			$this->profileRank = $newProfileRank;
		}

		/**
		 *accessor method for profile state
		 *
		 * @return string value of profile state
		 **/
		public function getProfileState() {
			return ($this->profileState);
		}

		/**
		 * mutator method for the profile state
		 *
		 * @param string $newProfileState new value of profile state
		 * @throws UnexpectedValueException if $newProfileState is not valid
		 **/
		public function setProfileState($newProfileState) {
			//verify the profile state is valid
			$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING);
			if($newProfileState === false) {
				throw(new UnexpectedValueException("profile state is not a valid string"));
			}

			// store the profile state
			$this->profileState = $newProfileState;
		}

		/**
		 * accessor method for profile type
		 *
		 * @return string value of profile type
		 **/
		public function getProfileType() {
			return ($this->profileType);
		}

		/**
		 * mutator method for the profile type
		 *
		 * @param string $newProfileType new value of profile type
		 * @throws UnexpectedValueException if $newProfileType is not valid
		 **/
		public function setProfileType($newProfileType) {
			//verify the profile type is valid
			$newProfileType = filter_var($newProfileType, FILTER_SANITIZE_STRING);
			if($newProfileType === false) {
				throw(new UnexpectedValueException("profile type is not a valid string"));
			}

			// store the profile type
			$this->profileType = $newProfileType;
		}

		/**
		 * accessor method for profile username
		 *
		 * @return string value of profile username
		 **/
		public function getProfileUsername() {
			return ($this->profileUsername);
		}

		/**
		 * mutator method for the profile username
		 *
		 * @param string $newProfileUsername new value of profile username
		 * @throws UnexpectedValueException if $newProfileUsername is not valid
		 **/
		public function setProfileUsername($newProfileUsername) {
			// verify the profile username is valid
			$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING);
			if($newProfileUsername === false) {
				throw(new UnexpectedValueException("profile username is not a valid string"));
			}

			//store the profile username
			$this->profileUsername = $newProfileUsername;
		}

		/**
		 * accessor method for profile zip
		 *
		 * @return string value of profile zip
		 **/
		public function getProfileZip() {
			return ($this->profileUsername);
		}

		/**
		 * mutator method for the profile zip
		 *
		 * @param string $newProfileZip new value of profile zip
		 * @throws UnexpectedValueException if $newProfileZip is not valid
		 **/
		public function setProfileZip($newProfileZip) {
			//verify the profile zip is valid
			$newProfileZip = filter_var($newProfileZip, FILTER_SANITIZE_STRING);
			if($newProfileZip === false) {
				throw(new UnexpectedValueException("profile zip is not a valid string"));
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
		$query = "UPDATE profile SET profileId = :profileId, :profileActivationToken, :profileAddress, :profileAvatarUrl, :profileBio, :profileCity, :profileEmail, :profileHash, :profileName, :profileRank, :profileState, :profileType, :profileUsername, :profileZip
						WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId, "profileActivationToken" => $this->profileActivationToken, "profileAddress" => $this->profileAddress, "profileAvatarUrl" => $this->profileAvatarUrl, "profileBio" => $this->profileBio, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileRank" => $this->profileRank, "profileState" => $this->profileState, "profileType" => $this->profileType, "profileUsername" => $this->profileUsername, "profileZip" => $this->profileZip];
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
		$parameters = ["profileId" => $this->profileId];
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
		} catch(InvalidArgumentException\RangeException\Exception\TypeError $exception) {
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
	 * get all profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of profile found or null of not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllProfiles(\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT profileId, profileActivationToken, profileAddress, profileAvatarUrl, profileBio, profileCity, profileEmail, profileHash, profileName, profileRank, profileState, profileType, profileUsername, profileZip";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of profiles
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
}
