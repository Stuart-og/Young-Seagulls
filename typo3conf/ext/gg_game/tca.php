<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gggame_scores'] = array (
	'ctrl' => $TCA['tx_gggame_scores']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,username,score'
	),
	'feInterface' => $TCA['tx_gggame_scores']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'username' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_game/locallang_db.xml:tx_gggame_scores.username',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'score' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_game/locallang_db.xml:tx_gggame_scores.score',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, username, score')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>