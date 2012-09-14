<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_photos/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggphotos_uploads'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads',		
		'label'     => 'user_uid',	
		'label_userFunc'     => 'EXT:gg_photos/lib/class.tx_ggphotos_image_display.php:&tx_ggphotos_image_display->get_image_title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',	
		'default_sortby' => 'ORDER BY uid DESC',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggphotos_uploads.gif',
	),
);
$TBE_STYLES['stylesheet2'] = t3lib_extMgm::extRelPath($_EXTKEY).'/css/hidden_different.css';
$TCA['tx_ggphotos_featured'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_featured',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggphotos_featured.gif',
	),
);
?>
