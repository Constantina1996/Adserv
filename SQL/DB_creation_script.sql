/*Here will put all thesql creation script after export from php my admin*/
CREATE DATABASE IF NOT EXISTS adserv;

CREATE TABLE IF NOT EXISTS admins (
  adminID int(11) NOT NULL AUTO_INCREMENT,
  usernameAdmin varchar(255) NOT NULL,
  passwordAdmin varchar(255) NOT NULL,
  PRIMARY KEY (adminID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS users (
  userID int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  keywordsAboutInterests varchar(255),
  age int(11),
  sex varchar(1),
  geo varchar(10),
  PRIMARY KEY (userID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

