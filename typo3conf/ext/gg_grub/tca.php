<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gggrub_grub'] = array (
	'ctrl' => $TCA['tx_gggrub_grub']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,intro,link,picture'
	),
	'feInterface' => $TCA['tx_gggrub_grub']['feInterface'],
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
			'label' => 'LLL:EXT:gg_grub/locallang_db.xml:tx_gggrub_grub.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'intro' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_grub/locallang_db.xml:tx_gggrub_grub.intro',		
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
		'link' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_grub/locallang_db.xml:tx_gggrub_grub.link',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'picture' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:gg_grub/locallang_db.xml:tx_gggrub_grub.picture',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_gggrub',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, intro;;;richtext[]:rte_transform[mode=ts];3-3-3, link, picture')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>