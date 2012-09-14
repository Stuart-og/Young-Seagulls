#
# Table structure for table 'tx_gggrub_grub'
#
CREATE TABLE tx_gggrub_grub (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	intro text,
	link varchar(255) DEFAULT '' NOT NULL,
	picture text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);