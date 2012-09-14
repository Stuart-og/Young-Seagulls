<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_tsaboutgallery_images'] = array (
	'ctrl' => $TCA['tx_tsaboutgallery_images']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,name,files'
	),
	'feInterface' => $TCA['tx_tsaboutgallery_images']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ts_about_gallery/locallang_db.xml:tx_tsaboutgallery_images.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'files' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ts_about_gallery/locallang_db.xml:tx_tsaboutgallery_images.files',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_tsaboutgallery',
				'show_thumbs' => 1,	
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 30,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, files')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>