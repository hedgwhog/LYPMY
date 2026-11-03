-- Table for users
CREATE TABLE user(
	userID INTEGER PRIMARY KEY AUTOINCREMENT,
	user TEXT,
	display TEXT,
	pass TEXT,
	groups TEXT
);

-- Table for groups
CREATE TABLE groups(
	groupID INTEGER PRIMARY KEY AUTOINCREMENT,
	owner INT,
	name TEXT,
	desc TEXT,
	members TEXT,
	picture TEXT,
	blacklist TEXT
);

CREATE TABLE message(
	by INT,
	cont TEXT
); -- For storing group messages

CREATE TABLE invite(
	by TEXT,
	user TEXT,
	accept BOOL DEFAULT FALSE,
	co BOOL DEFAULT FALSE,
	ban INT default (printf('%02d%s',
        CAST(strftime('%W', 'now') AS INTEGER) + 1,
        strftime('%Y', 'now')
    ))
); -- For handling invites

CREATE TABLE image(
	by TEXT,
	groups TEXT,
	stamp INT default (strftime('%W', 'now') || strftime('%Y', 'now')),
	img TEXT
); -- Table for images n collages

CREATE TRIGGER limit_entries
BEFORE INSERT ON image
WHEN (
    SELECT COUNT(*)
    FROM image
    WHERE "by" = NEW."by"
      AND "groups" = NEW."groups"
      AND stamp = NEW.stamp
) >= 5
BEGIN
    SELECT RAISE(ABORT, 'Collage for this week complete');
END; -- limit to 5
