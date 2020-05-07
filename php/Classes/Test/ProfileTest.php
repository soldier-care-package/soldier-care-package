<?php
namespace Cohort28SCP\SoldierCarePackage\Test;

require_once(dirname(__DIR__,2) . "/lib/uuid.php");
require_once(dirname(__DIR__) . "/autoload.php");

use Cohort28SCP\SoldierCarePackage\{ Profile, Request};

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class profileTest extends SoldierCarePackageTest {
	/**
	 * Profile that created the class; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile;

	/**
	 * valid profile activation token to create the profile object to own the test
	 * @var string $VALID_ACTIVATION_TOKEN
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN;

	/**
	 * address of the soldier profile
	 * @var string $VALID_ADDRESS
	 **/
	protected $VALID_PROFILE_ADDRESS;

	/**
	 * the avatar url for the profile
	 * @var string $VALID_AVATAR_URL
	 **/
	protected $VALID_PROFILE_AVATAR_URL;

	/**
	 * bio for the soldier profile
	 * @var string $VALID_BIO
	 **/
	protected $VALID_PROFILE_BIO;

	/**
	 * city where the soldier is stationed
	 */
	protected $VALID_PROFILE_CITY;

	/**
	 * the user email for the profile
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL;

	/**
	 * the hash for the user profile
	 * @var string $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * the full name of the soldier for the shipping address
	 * @var string $VALID_NAME
	 */
	protected $VALID_PROFILE_NAME;

	/**
	 * the soldiers rank user for the shipping address
	 * @var string $VALID_RANK
	 */
	protected $VALID_PROFILE_RANK;

	/**
	 * the state where the soldier is stationed, used for the shipping address
	 * @var string $VALID_STATE
	 */
	protected $VALID_PROFILE_STATE;

	/**
	 * the type of profile, soldier or user
	 * @var string $VALID_TYPE
	 */
	protected $VALID_PROFILE_TYPE;

	/**
	 * the username for the profile
	 * @var string $VALID_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME;

	/**
	 * the zip code where the soldier is stationed
	 * @var string $VALID_ZIP
	 */
	protected $VALID_PROFILE_ZIP;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Profile to own the test Tweet
		$this->profile = new Profile(\Ramsey\Uuid, string, string,string, string, string, string, string, string, string, string, string, string, string);
		$this->profile->insert($this->getPDO());

		$this->VALID_PROFILE_ACTIVATION_TOKEN = new \String();

		$this->VALID_PROFILE_ADDRESS = new \String();

		$this->VALID_PROFILE_AVATAR_URL = new \String();

		$this->VALID_PROFILE_BIO = new \String();

		$this->VALID_PROFILE_CITY = new \String();

		$this->VALID_PROFILE_EMAIL = new \String();

		$this->VALID_PROFILE_HASH = new \String();

		$this->VALID_PROFILE_NAME = new \String();

		$this->VALID_PROFILE_RANK = new \String();

		$this->VALID_PROFILE_STATE = new \String();

		$this->VALID_PROFILE_TYPE = new \String();

		$this->VALID_PROFILE_USERNAME = new \String();

		$this->VALID_PROFILE_ZIP = new \String();

	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profile->getProfileId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS, $this->VALID_PROFILE_AVATAR_URL, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_RANK, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress(), $this->VALID_PROFILE_ADDRESS);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfileRank(), $this->VALID_PROFILE_RANK);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_PROFILE_TYPE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profile->getProfileId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS, $this->VALID_PROFILE_AVATAR_URL, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_RANK, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// edit the Profile and update it in mySQL
		$profile->setProfileActivationToken($this->VALID_PROFILE_ACTIVATION_TOKEN);
		$profile->setProfileAddress($this->VALID_PROFILE_ADDRESS);
		$profile->setProfileAvatarUrl($this->VALID_PROFILE_AVATAR_URL);
		$profile->setProfileBio($this->VALID_PROFILE_BIO);
		$profile->setProfileCity($this->VALID_PROFILE_CITY);
		$profile->setProfileEmail($this->VALID_PROFILE_EMAIL);
		$profile->setProfileHash($this->VALID_PROFILE_HASH);
		$profile->setProfileName($this->VALID_PROFILE_NAME);
		$profile->setProfileRank($this->VALID_PROFILE_RANK);
		$profile->setProfileState($this->VALID_PROFILE_STATE);
		$profile->setProfileType($this->VALID_PROFILE_TYPE);
		$profile->setProfileUsername($this->VALID_PROFILE_USERNAME);
		$profile->setProfileZip($this->VALID_PROFILE_ZIP);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress(), $this->VALID_PROFILE_ADDRESS);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfileRank(), $this->VALID_PROFILE_RANK);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_PROFILE_TYPE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}


	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profile->getProfileId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS, $this->VALID_PROFILE_AVATAR_URL, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_RANK, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profile->getProfileId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS, $this->VALID_PROFILE_AVATAR_URL, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_RANK, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];

		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress(), $this->VALID_PROFILE_ADDRESS);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfileRank(), $this->VALID_PROFILE_RANK);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_PROFILE_TYPE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile by activation token
	 **/
	public function testGetValidProfileByProfileActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN->getProfileActivationToken(), $this->VALID_PROFILE_ADDRESS, $this->VALID_PROFILE_AVATAR_URL, $this->VALID_PROFILE_BIO, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME, $this->VALID_PROFILE_RANK, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileByProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress(), $this->VALID_PROFILE_ADDRESS);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfileRank(), $this->VALID_PROFILE_RANK);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_PROFILE_TYPE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing all soldier profiles
	 **/
	public function testGetAllValidSoldierProfiles() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Tweet($profileId, $this->profile->getProfileId(), $this->VALID_PROFILE_TYPE, $this->VALID_PROFILE_TYPE);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getAllSoldierProfiles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getTweetId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileAcitvationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress(), $this->VALID_PROFILE_ADDRESS);
		$this->assertEquals($pdoProfile->getProfileAvatarUrl(), $this->VALID_PROFILE_AVATAR_URL);
		$this->assertEquals($pdoProfile->getProfileBio(), $this->VALID_PROFILE_BIO);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($pdoProfile->getProfileRank(), $this->VALID_PROFILE_RANK);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileType(), $this->VALID_PROFILE_TYPE);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_PROFILE_USERNAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}
}
