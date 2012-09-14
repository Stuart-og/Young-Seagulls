<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_tswall_posts'] = array (
	'ctrl' => $TCA['tx_tswall_posts']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,user_uid,message,response_to'
	),
	'feInterface' => $TCA['tx_tswall_posts']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'user_uid' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ts_wall/locallang_db.xml:tx_tswall_posts.user_uid',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'message' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ts_wall/locallang_db.xml:tx_tswall_posts.message',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'response_to' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ts_wall/locallang_db.xml:tx_tswall_posts.response_to',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, user_uid, message, response_to')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>