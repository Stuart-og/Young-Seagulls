<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggcheerleaders_gallery'] = array (
	'ctrl' => $TCA['tx_ggcheerleaders_gallery']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,name,description,image'
	),
	'feInterface' => $TCA['tx_ggcheerleaders_gallery']['feInterface'],
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
			'label' => 'LLL:EXT:gg_cheerleaders/locallang_db.xml:tx_ggcheerleaders_gallery.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_cheerleaders/locallang_db.xml:tx_ggcheerleaders_gallery.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_cheerleaders/locallang_db.xml:tx_ggcheerleaders_gallery.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggcheerleaders',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, description, image')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>