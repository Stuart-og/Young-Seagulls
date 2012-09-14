#
# Table structure for table 'tx_ggmeettheteam_players'
#
CREATE TABLE tx_ggmeettheteam_players (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	firstname varchar(255) DEFAULT '' NOT NULL,
	lastname varchar(255) DEFAULT '' NOT NULL,
	number varchar(255) DEFAULT '' NOT NULL,
	position varchar(255) DEFAULT '' NOT NULL,
	biog text,
	email varchar(255) DEFAULT '' NOT NULL,
	pics text,
	rating varchar(255) DEFAULT '' NOT NULL,
	nationality varchar(255) DEFAULT '' NOT NULL,
	nickname varchar(255) DEFAULT '' NOT NULL,
	dob int(11) DEFAULT '0' NOT NULL,
	special text,
	hobbies text,
	music text,
	sporting_idol varchar(255) DEFAULT '' NOT NULL,
	player_type int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);