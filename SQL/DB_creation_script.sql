/*Here will put all thesql creation script after export from php my admin*/
CREATE DATABASE IF NOT EXISTS adserv;

CREATE TABLE IF NOT EXISTS admins (
  adminID int(11) NOT NULL AUTO_INCREMENT,
  usernameAdmin varchar(255) NOT NULL,
  passwordAdmin varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  bidcount int(11) DEFAULT '0', 
  PRIMARY KEY (adminID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;



CREATE TABLE IF NOT EXISTS bids (
  bidID int(11) NOT NULL AUTO_INCREMENT,
  adminID int(11),
  topic varchar(255) NOT NULL,
  price float(11),
  geography varchar(100),
  PRIMARY KEY (bidID),
  CONSTRAINT FOREIGN KEY (adminID) REFERENCES admins(adminID)
    ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


CREATE TABLE IF NOT EXISTS users (
  userID int(11) NOT NULL AUTO_INCREMENT,
  adminID int(11),
  username varchar(255) NOT NULL,
  keywordsAboutInterests varchar(255),
  age int(11),
  sex varchar(1),
  geo varchar(100),
  PRIMARY KEY (userID),
  CONSTRAINT FOREIGN KEY (adminID) REFERENCES admins(adminID)
    ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

