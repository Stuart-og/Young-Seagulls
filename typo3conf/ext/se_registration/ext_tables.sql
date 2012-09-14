#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	tx_seregistration_surname varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_gender varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_school varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_parent_name varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_play_for varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_season_ticket varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_fav_player varchar(255) DEFAULT '' NOT NULL,
	tx_seregistration_additional_material varchar(255) DEFAULT '' NOT NULL
);
