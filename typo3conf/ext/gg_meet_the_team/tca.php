<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggmeettheteam_players'] = array (
	'ctrl' => $TCA['tx_ggmeettheteam_players']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,firstname,lastname,number,position,biog,email,pics,rating,nationality,nickname,dob,special,hobbies,music,sporting_idol,player_type'
	),
	'feInterface' => $TCA['tx_ggmeettheteam_players']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'firstname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.firstname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'lastname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.lastname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'number' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.number',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'position' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.position',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'biog' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.biog',		
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
		'email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.email',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'pics' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.pics',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggmeettheteam',
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 50,
			)
		),
		'rating' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.rating',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'nationality' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.nationality',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'nickname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.nickname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'dob' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.dob',		
			'config' => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'special' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.special',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'hobbies' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.hobbies',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'music' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.music',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'sporting_idol' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.sporting_idol',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'player_type' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.player_type',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.player_type.I.0', '0'),
					array('LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.player_type.I.1', '1'),
					array('LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.player_type.I.2', '2'),
					array('LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players.player_type.I.3', '3'),
				),
				'size' => 4,	
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, firstname, lastname, number, position, biog;;;richtext[]:rte_transform[mode=ts], email, pics, rating, nationality, nickname, dob, special, hobbies, music, sporting_idol, player_type')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>