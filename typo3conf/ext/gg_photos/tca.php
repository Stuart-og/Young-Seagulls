<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggphotos_uploads'] = array (
	'ctrl' => $TCA['tx_ggphotos_uploads']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,file_name,user_uid,type,special_type,special_title'
	),
	'feInterface' => $TCA['tx_ggphotos_uploads']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'file_name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.file_name',		
			'config' => array (
				'form_type' => 'user',
				'userFunc' => 'EXT:gg_photos/lib/class.tx_ggphotos_image_display.php:&tx_ggphotos_image_display->show_preview',
				'base_dir' => 'gg_photos',
			)
		),
		'user_uid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.user_uid',		
			'config' => array (
				'form_type' => 'user',
				'userFunc' => 'EXT:gg_photos/lib/class.tx_ggphotos_image_display.php:&tx_ggphotos_image_display->show_username',
//				'type' => 'group',	
//				'internal_type' => 'db',	
//				'allowed' => 'fe_users',	
//				'size' => 1,	
//				'minitems' => 0,
//				'maxitems' => 1,
			)
		),
		'type' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.type.I.0', '0'),
					array('LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.type.I.1', '1'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'special_type' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.special_type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.special_type.I.0', '0'),
					array('LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.special_type.I.1', '1'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'special_title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads.special_title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, file_name, user_uid, type, special_type, special_title'),
		'1' => array('showitem' => 'hidden;;1;;1-1-1, file_name, user_uid, type, special_type, special_title')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_ggphotos_featured'] = array (
	'ctrl' => $TCA['tx_ggphotos_featured']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,selection'
	),
	'feInterface' => $TCA['tx_ggphotos_featured']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_featured.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'selection' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_featured.selection',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'tx_ggphotos_uploads',	
				'foreign_table_where' => 'AND !tx_ggphotos_uploads.hidden AND tx_ggphotos_uploads.pid=###CURRENT_PID### ORDER BY tx_ggphotos_uploads.uid',	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, selection;;;;3-3-3')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>
