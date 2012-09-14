#
# Table structure for table 'tx_ggfunstuff_funstuff'
#
CREATE TABLE tx_ggfunstuff_funstuff (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	file text,
	thumbnail text,
	description text,
	colouring_in tinyint(3) DEFAULT '0' NOT NULL,
	desktop tinyint(3) DEFAULT '0' NOT NULL,
	cheerleaders tinyint(3) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);