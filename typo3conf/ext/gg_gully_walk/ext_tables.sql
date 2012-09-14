#
# Table structure for table 'tx_gggullywalk_gw'
#
CREATE TABLE tx_gggullywalk_gw (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	walk_type int(11) DEFAULT '0' NOT NULL,
	speech_bubble text,
	speech_bubble_not_in text,
	page text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);