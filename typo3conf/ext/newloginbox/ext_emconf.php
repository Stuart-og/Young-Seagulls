<?php

########################################################################
# Extension Manager/Repository config file for ext "newloginbox".
#
# Auto generated 08-12-2009 11:45
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'New front end login box',
	'description' => 'This is an alternative to the good old login box. This version features a little more functionality, including success/error messages, cookie check, forgot password etc.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '3.1.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'obsolete',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Stefan Strasser (formerly Kasper Skårhøj)',
	'author_email' => 'strada@stradax.net',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '3.5.0-4.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:24:{s:9:"ChangeLog";s:4:"3048";s:8:"TODO.txt";s:4:"4c6c";s:20:"class.ext_update.php";s:4:"a885";s:32:"class.tx_newloginbox_feusers.php";s:4:"bec1";s:12:"ext_icon.gif";s:4:"7160";s:17:"ext_localconf.php";s:4:"f537";s:15:"ext_php_api.dat";s:4:"8547";s:14:"ext_tables.php";s:4:"7b21";s:28:"ext_typoscript_editorcfg.txt";s:4:"bdd5";s:24:"ext_typoscript_setup.txt";s:4:"e388";s:15:"flexform_ds.xml";s:4:"7ad5";s:19:"flexform_ds_pi3.xml";s:4:"c177";s:13:"locallang.xml";s:4:"e069";s:16:"locallang_db.xml";s:4:"0232";s:12:"doc/TODO.txt";s:4:"b90c";s:14:"doc/manual.sxw";s:4:"9681";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:32:"pi1/class.tx_newloginbox_pi1.php";s:4:"86f8";s:40:"pi1/class.tx_newloginbox_pi1_wizicon.php";s:4:"3695";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"a5d8";s:32:"pi3/class.tx_newloginbox_pi3.php";s:4:"f5ac";s:17:"pi3/locallang.xml";s:4:"5aee";s:23:"res/newloginbox_00.html";s:4:"ea0f";}',
);

?>