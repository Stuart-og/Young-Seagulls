#
# Table structure for table 'tx_ggfanzonephotos_photos'
#
CREATE TABLE tx_ggfanzonephotos_photos (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	caption varchar(255) DEFAULT '' NOT NULL,
	image text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);