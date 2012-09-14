<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggfanzonemessages_messages'] = array (
	'ctrl' => $TCA['tx_ggfanzonemessages_messages']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,user_uid,message,response_to'
	),
	'feInterface' => $TCA['tx_ggfanzonemessages_messages']['feInterface'],
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
			'label' => 'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tx_ggfanzonemessages_messages.user_uid',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'message' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tx_ggfanzonemessages_messages.message',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'response_to' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tx_ggfanzonemessages_messages.response_to',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, user_uid, message;;;richtext[]:rte_transform[mode=ts], response_to')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>