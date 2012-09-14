<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gggullywalk_gw'] = array (
	'ctrl' => $TCA['tx_gggullywalk_gw']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,walk_type,speech_bubble,speech_bubble_not_in,page'
	),
	'feInterface' => $TCA['tx_gggullywalk_gw']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'walk_type' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.0', '0'),
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.1', '1'),
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.2', '2'),
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.3', '3'),
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.4', '4'),
					array('LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.walk_type.I.5', '5'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'speech_bubble' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.speech_bubble',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'speech_bubble_not_in' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.speech_bubble_not_in',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'page' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw.page',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'pages',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, walk_type, speech_bubble, speech_bubble_not_in, page')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>