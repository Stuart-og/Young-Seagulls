<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ggfunstuff_funstuff'] = array (
	'ctrl' => $TCA['tx_ggfunstuff_funstuff']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,name,file,thumbnail,description,colouring_in,desktop,cheerleaders'
	),
	'feInterface' => $TCA['tx_ggfunstuff_funstuff']['feInterface'],
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
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'file' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.file',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	
				'disallowed' => 'php,php3',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggfunstuff',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'thumbnail' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.thumbnail',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_ggfunstuff',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'colouring_in' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.colouring_in',		
			'config' => array (
				'type' => 'check',
			)
		),
		'desktop' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.desktop',		
			'config' => array (
				'type' => 'check',
			)
		),
		'cheerleaders' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff.cheerleaders',		
			'config' => array (
				'type' => 'check',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, file, thumbnail, description, colouring_in, desktop, cheerleaders')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>