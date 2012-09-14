<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggthescore_match'] = array (
	'ctrl' => $TCA['tx_ggthescore_match']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,opposition,homeaway,datetime,venue,brightongoals,oppositiongoals,competition,report,media,preview,link'
	),
	'feInterface' => $TCA['tx_ggthescore_match']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'opposition' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.opposition',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'homeaway' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.homeaway',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.homeaway.I.0', '0'),
					array('LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.homeaway.I.1', '1'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'datetime' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.datetime',		
			'config' => array (
				'type'     => 'input',
				'size'     => '12',
				'max'      => '20',
				'eval'     => 'datetime',
				'checkbox' => '0',
				'default'  => '0'
			)
		),
		'venue' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.venue',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'brightongoals' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.brightongoals',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'oppositiongoals' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.oppositiongoals',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'competition' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.competition',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'report' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.report',		
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
		'media' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.media',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggthescore',
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'preview' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.preview',		
			'config' => array (
				'type' => 'check',
				'default' => 1,
			)
		),
		'link' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match.link',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, opposition, homeaway, datetime, venue, brightongoals, oppositiongoals, competition, report;;;richtext[]:rte_transform[mode=ts], media, preview, link')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>