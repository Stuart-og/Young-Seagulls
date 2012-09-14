<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggskills_videos'] = array (
	'ctrl' => $TCA['tx_ggskills_videos']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,description,file,thumbnail,rating,skill_level'
	),
	'feInterface' => $TCA['tx_ggskills_videos']['feInterface'],
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
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.description',		
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
		'file' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.file',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggskills',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'thumbnail' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.thumbnail',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggskills',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'rating' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.rating',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'skill_level' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos.skill_level',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, description;;;richtext[]:rte_transform[mode=ts];3-3-3, file, thumbnail, rating, skill_level')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>