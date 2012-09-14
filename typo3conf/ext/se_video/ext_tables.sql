#
# Table structure for table 'tx_sevideo_video'
#
CREATE TABLE tx_sevideo_video (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	rating varchar(255) DEFAULT '' NOT NULL,
	video text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);