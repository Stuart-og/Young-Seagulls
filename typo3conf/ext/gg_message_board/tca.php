<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggmessageboard_message'] = array (
	'ctrl' => $TCA['tx_ggmessageboard_message']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,user_uid,message,response_to,reported_by,liked_by,crtime'
	),
	'feInterface' => $TCA['tx_ggmessageboard_message']['feInterface'],
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
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.user_uid',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'message' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.message',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'response_to' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.response_to',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_ggmessageboard_message',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'reported_by' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.reported_by',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 100,	
				"MM" => "tx_ggmessageboard_message_reported_by_mm",
			)
		),
		'liked_by' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.liked_by',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 100,	
				"MM" => "tx_ggmessageboard_message_liked_by_mm",
			)
		),
		'crtime' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message.crtime',		
			'config' => array (
				'type'     => 'input',
				'size'     => '12',
				'max'      => '20',
				'eval'     => 'datetime',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, user_uid, message, response_to, reported_by, liked_by, crtime')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>