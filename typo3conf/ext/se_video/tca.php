<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_sevideo_video'] = array (
	'ctrl' => $TCA['tx_sevideo_video']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,name,description,rating,video'
	),
	'feInterface' => $TCA['tx_sevideo_video']['feInterface'],
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
			'label' => 'LLL:EXT:se_video/locallang_db.xml:tx_sevideo_video.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:se_video/locallang_db.xml:tx_sevideo_video.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'rating' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:se_video/locallang_db.xml:tx_sevideo_video.rating',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'video' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:se_video/locallang_db.xml:tx_sevideo_video.video',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_sevideo',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, description, rating, video')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>