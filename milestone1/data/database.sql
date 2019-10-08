DROP TABLE IF EXISTS wp_users;

CREATE TABLE wp_users (
  userid int(5) NOT NULL auto_increment,
  email varchar(32) NOT NULL,
  password varchar(32) NOT NULL,
  lastname varchar(32),
  firstname varchar(32),
  confirmcode varchar(6),
  active varchar(1),
  PRIMARY KEY (userid)
) ENGINE=MyISAM;

insert into wp_users values(NULL, 'pwang001@odu.edu','pwang001','Wang','Pei',NULL,'N');