#
# Table structure for table 'tx_ggthescore_match'
#
CREATE TABLE tx_ggthescore_match (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	opposition varchar(255) DEFAULT '' NOT NULL,
	homeaway int(11) DEFAULT '0' NOT NULL,
	datetime int(11) DEFAULT '0' NOT NULL,
	venue varchar(255) DEFAULT '' NOT NULL,
	brightongoals varchar(255) DEFAULT '' NOT NULL,
	oppositiongoals varchar(255) DEFAULT '' NOT NULL,
	competition varchar(255) DEFAULT '' NOT NULL,
	report text,
	media text,
	preview tinyint(3) DEFAULT '0' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);