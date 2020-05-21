ALTER DATABASE CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE profile(
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAddress VARCHAR (32),
	profileAvatarUrl VARCHAR (255),
	profileBio VARCHAR (500),
	profileCity CHAR(3),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileName CHAR(100) NOT NULL,
	profileRank VARCHAR(32),
	profileState CHAR(2),
	profileType VARCHAR(15) NOT NULL,
	profileUsername VARCHAR(32) NOT NULL,
	profileZip VARCHAR(9),
	UNIQUE(profileEmail),
	UNIQUE(profileUsername),
	PRIMARY KEY(profileId)
);

CREATE TABLE request(
	requestId BINARY(16) NOT NULL,
	requestProfileId BINARY(16) NOT NULL,
	requestContent VARCHAR(500) NOT NULL,
	requestDate DATETIME(6) NOT NULL,
	INDEX(requestProfileId),
	FOREIGN KEY(requestProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(requestId)
);

CREATE TABLE donation(
	donationId BINARY(16) NOT NULL,
	donationProfileId BINARY(16) NOT NULL,
	donationDate DATETIME(6) NOT NULL,
	INDEX(donationProfileId),
	FOREIGN KEY(donationProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(donationId)
);

CREATE TABLE item(
	itemId BINARY(16) NOT NULL,
	itemDonationId BINARY(16),
	itemRequestId BINARY(16) NOT NULL,
	itemTrackingNumber CHAR(20),
	itemUrl VARCHAR(255) NOT NULL,
	INDEX(itemDonationId),
	INDEX(itemRequestId),
	FOREIGN KEY(itemDonationId) REFERENCES donation(donationId),
	FOREIGN KEY(itemRequestId) REFERENCES request(requestId),
	PRIMARY KEY(itemId)
);

# select hex(requestId),hex(requestProfileId), requestContent, requestDate
#   from request;