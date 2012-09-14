<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggfanzonephotos_photos'] = array (
	'ctrl' => $TCA['tx_ggfanzonephotos_photos']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,caption,image'
	),
	'feInterface' => $TCA['tx_ggfanzonephotos_photos']['feInterface'],
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
			'label' => 'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tx_ggfanzonephotos_photos.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'caption' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tx_ggfanzonephotos_photos.caption',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tx_ggfanzonephotos_photos.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggfanzonephotos',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, caption;;;;3-3-3, image')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>