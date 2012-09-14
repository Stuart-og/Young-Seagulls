<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggstadiumgallery_pictures'] = array (
	'ctrl' => $TCA['tx_ggstadiumgallery_pictures']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,pictures,name,description'
	),
	'feInterface' => $TCA['tx_ggstadiumgallery_pictures']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'pictures' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tx_ggstadiumgallery_pictures.pictures',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggstadiumgallery',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tx_ggstadiumgallery_pictures.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tx_ggstadiumgallery_pictures.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, pictures, name, description')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>