#
# Table structure for table 'tx_tshomevideos_videos'
#
CREATE TABLE tx_tshomevideos_videos (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	description text,
	file text,
	thumbnail text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);