<?php

###########################
## EXTENSION: cms
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/cms/ext_tables.php
###########################

$_EXTKEY = 'cms';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


# TYPO3 SVN ID: $Id: ext_tables.php 6289 2009-10-28 09:30:11Z steffenk $
if (!defined ('TYPO3_MODE'))	die ('Access denied.');


if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModule('web','layout','top',t3lib_extMgm::extPath($_EXTKEY).'layout/');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_layout','EXT:cms/locallang_csh_weblayout.xml');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_info','EXT:cms/locallang_csh_webinfo.xml');

	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_cms_webinfo_page',
		t3lib_extMgm::extPath($_EXTKEY).'web_info/class.tx_cms_webinfo.php',
		'LLL:EXT:cms/locallang_tca.xml:mod_tx_cms_webinfo_page'
	);
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_cms_webinfo_lang',
		t3lib_extMgm::extPath($_EXTKEY).'web_info/class.tx_cms_webinfo_lang.php',
		'LLL:EXT:cms/locallang_tca.xml:mod_tx_cms_webinfo_lang'
	);
}


// ******************************************************************
// Extend 'pages'-table
// ******************************************************************

if (TYPO3_MODE=='BE')	{
	// Setting ICON_TYPES (obsolete by the removal of the plugin_mgm extension)
	$ICON_TYPES = array(
		'shop' => array('icon' => 'gfx/i/modules_shop.gif'),
		'board' => array('icon' => 'gfx/i/modules_board.gif'),
		'news' => array('icon' => 'gfx/i/modules_news.gif'),
		'fe_users' => array('icon' => 'gfx/i/fe_users.gif'),
		'approve' => array('icon' => 'gfx/state_checked.png'),
	);
}

	// Adding pages_types:
		// t3lib_div::array_merge() MUST be used!
	$PAGES_TYPES = t3lib_div::array_merge(array(
		'3' => array(
			'icon' => 'pages_link.gif'
		),
		'4' => array(
			'icon' => 'pages_shortcut.gif'
		),
		'5' => array(
			'icon' => 'pages_notinmenu.gif'
		),
		'6' => array(
			'type' => 'web',
			'icon' => 'be_users_section.gif',
			'allowedTables' => '*'
		),
		'7' => array(
			'icon' => 'pages_mountpoint.gif'
		),
		'199' => array(		// TypoScript: Limit is 200. When the doktype is 200 or above, the page WILL NOT be regarded as a 'page' by TypoScript. Rather is it a system-type page
			'type' => 'sys',
			'icon' => 'spacer_icon.gif',
		)
	),$PAGES_TYPES);

	// Add allowed records to pages:
	t3lib_extMgm::allowTableOnStandardPages('pages_language_overlay,tt_content,sys_template,sys_domain');

	// Merging in CMS doktypes:
	array_splice(
		$TCA['pages']['columns']['doktype']['config']['items'],
		1,
		0,
		array(
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.4', '6', 'i/be_users_section.gif'),
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.link', '--div--'),
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.2', '4', 'i/pages_shortcut.gif'),
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.5', '7', 'i/pages_mountpoint.gif'),
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.8', '3', 'i/pages_link.gif'),
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.special', '--div--')
		)
	);
	array_splice(
		$TCA['pages']['columns']['doktype']['config']['items'],
		10,
		0,
		array(
			array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.7', '199', 'i/spacer_icon.gif')
		)
	);
	array_unshift(
		$TCA['pages']['columns']['doktype']['config']['items'],
		array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.page', '--div--')
	);

	// Setting enablecolumns:
	$TCA['pages']['ctrl']['enablecolumns'] = array (
		'disabled' => 'hidden',
		'starttime' => 'starttime',
		'endtime' => 'endtime',
		'fe_group' => 'fe_group',
	);

	// Enable Tabs
	$TCA['pages']['ctrl']['dividers2tabs'] = 1;

	// Adding default value columns:
	$TCA['pages']['ctrl']['useColumnsForDefaultValues'].=',fe_group,hidden';
	$TCA['pages']['ctrl']['transForeignTable'] = 'pages_language_overlay';

	// Adding new columns:
	$TCA['pages']['columns'] = array_merge($TCA['pages']['columns'],array(
		'hidden' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.hidden',
			'config' => array (
				'type' => 'check',
				'default' => '1'
			)
		),
		'starttime' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'endtime' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0',
				'range' => array (
					'upper' => mktime(0,0,0,12,31,2020),
				)
			)
		),
		'layout' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.layout',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:lang/locallang_general.xml:LGL.normal', '0'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.layout.I.1', '1'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.layout.I.2', '2'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.layout.I.3', '3')
				),
				'default' => '0'
			)
		),
		'fe_group' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config' => array (
				'type' => 'select',
				'size' => 5,
				'maxitems' => 20,
				'items' => array (
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'exclusiveKeys' => '-1,-2',
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => 'ORDER BY fe_groups.title',
			)
		),
		'extendToSubpages' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.extendToSubpages',
			'config' => array (
				'type' => 'check'
			)
		),
		'nav_title' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.nav_title',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max' => '255',
				'checkbox' => '',
				'eval' => 'trim'
			)
		),
		'nav_hide' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.nav_hide',
			'config' => array (
				'type' => 'check'
			)
		),
		'subtitle' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.subtitle',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max' => '255',
				'eval' => ''
			)
		),
		'target' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.target',
			'config' => array (
				'type' => 'input',
				'size' => '20',
				'max' => '80',
				'eval' => 'trim',
				'checkbox' => ''
			)
		),
		'alias' => array (
			'displayCond' => 'VERSION:IS:false',
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.alias',
			'config' => array (
				'type' => 'input',
				'size' => '10',
				'max' => '32',
				'eval' => 'nospace,alphanum_x,lower,unique',
				'softref' => 'notify'
			)
		),
		'url' => array (
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.url',
			'config' => array (
				'type' => 'input',
				'size' => '25',
				'max' => '255',
				'eval' => 'trim,required',
				'softref' => 'url'
			)
		),
		'urltype' => array (
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.type',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', '0'),
					array('http://', '1'),
					array('https://', '4'),
					array('ftp://', '2'),
					array('mailto:', '3')
				),
				'default' => '1'
			)
		),
		'lastUpdated' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.lastUpdated',
			'config' => array (
				'type' => 'input',
				'size' => '12',
				'max' => '20',
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'newUntil' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.newUntil',
			'config' => array (
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'cache_timeout' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.1', 60),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.2', 300),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.3', 900),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.4', 1800),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.5', 3600),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.6', 14400),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.7', 86400),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.8', 172800),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.9', 604800),
					array('LLL:EXT:cms/locallang_tca.xml:pages.cache_timeout.I.10', 2678400)
				),
				'default' => '0'
			)
		),
		'no_cache' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.no_cache',
			'config' => array (
				'type' => 'check'
			)
		),
		'no_search' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.no_search',
			'config' => array (
				'type' => 'check'
			)
		),
		'shortcut' => array (
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.shortcut_page',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '3',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
			),
		),
		'shortcut_mode' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.shortcut_mode',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:cms/locallang_tca.xml:pages.shortcut_mode.I.1', 1),
					array('LLL:EXT:cms/locallang_tca.xml:pages.shortcut_mode.I.2', 2),
				),
				'default' => '0'
			)
		),
		'content_from_pid' => array (
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.content_from_pid',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
			),
		),
		'mount_pid' => array (
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.mount_pid',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'show_thumbs' => '1',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
			),
		),
		'keywords' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.keywords',
			'config' => array (
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			)
		),
		'description' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.description',
			'config' => array (
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			)
		),
		'abstract' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.abstract',
			'config' => array (
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			)
		),
		'author' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.author',
			'config' => array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'author_email' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.email',
			'config' => array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '80',
				'softref' => 'email[subst]'
			)
		),
		'media' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.media',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'].',html,htm,ttf,txt,css',
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'uploadfolder' => 'uploads/media',
				'show_thumbs' => '1',
				'size' => '3',
				'maxitems' => '5',
				'minitems' => '0'
			)
		),
		'is_siteroot' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.is_siteroot',
			'config' => array (
				'type' => 'check'
			)
		),
		'mount_pid_ol' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.mount_pid_ol',
			'config' => array (
				'type' => 'check'
			)
		),
		'module' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.module',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', '', ''),
					array('LLL:EXT:cms/locallang_tca.xml:pages.module.I.1', 'shop', 'i/modules_shop.gif'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.module.I.2', 'board', 'i/modules_board.gif'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.module.I.3', 'news', 'i/modules_news.gif'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.module.I.4', 'fe_users', 'i/fe_users.gif'),
					array('LLL:EXT:cms/locallang_tca.xml:pages.module.I.6', 'approve', 'state_checked.png')
				),
				'default' => '',
				'iconsInOptionTags' => 1,
				'noIconsBelowSelect' => 1,
			)
		),
		'fe_login_mode' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.fe_login_mode',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:cms/locallang_tca.xml:pages.fe_login_mode.disableAll', 1),
					array('LLL:EXT:cms/locallang_tca.xml:pages.fe_login_mode.disableGroups', 3),
					array('LLL:EXT:cms/locallang_tca.xml:pages.fe_login_mode.enableAgain', 2),
				)
			)
		),
		'l18n_cfg' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.l18n_cfg',
			'config' => array (
				'type' => 'check',
				'items' => array (
					array('LLL:EXT:cms/locallang_tca.xml:pages.l18n_cfg.I.1', ''),
					array($GLOBALS['TYPO3_CONF_VARS']['FE']['hidePagesIfNotTranslatedByDefault'] ? 'LLL:EXT:cms/locallang_tca.xml:pages.l18n_cfg.I.2a' : 'LLL:EXT:cms/locallang_tca.xml:pages.l18n_cfg.I.2', ''),
				),
			)
		),
	));

		// Add columns to info-display list.
	$TCA['pages']['interface']['showRecordFieldList'].=',alias,hidden,starttime,endtime,fe_group,url,target,no_cache,shortcut,keywords,description,abstract,newUntil,lastUpdated,cache_timeout';


		// Totally overriding all type-settings:
	$TCA['pages']['types'] = array (
			// normal
		'1' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle, nav_title,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
				--palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3, abstract, keywords, description,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;6-6-6, storage_pid;;7, l18n_cfg, module, content_from_pid,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
				starttime, endtime, fe_login_mode, fe_group, extendToSubpages,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// external URL
		'3' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.url,
				url;;;;3-3-3, urltype,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7, l18n_cfg,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
				starttime, endtime, fe_group, extendToSubpages,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// shortcut
		'4' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.shortcut,
				shortcut;;;;3-3-3, shortcut_mode,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7, l18n_cfg,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
				starttime, endtime, fe_group, extendToSubpages,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// not in menu
		'5' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7, l18n_cfg, module, content_from_pid,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
				starttime, endtime, fe_login_mode, fe_group, extendToSubpages,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// mount page
		'7' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle, nav_title,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.mount,
				mount_pid;;;;3-3-3, mount_pid_ol,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7, l18n_cfg, module, content_from_pid,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
				starttime, endtime, fe_login_mode, fe_group, extendToSubpages,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// spacer
		'199' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, title,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// sysfolder
		'254' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, title;LLL:EXT:lang/locallang_general.xml:LGL.title,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
				media,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
				TSconfig;;6;nowrap;5-5-5, storage_pid;;7, module,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		'),
			// trash
		'255' => array('showitem' =>
				'doktype;;2;;1-1-1, hidden, title,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		')
	);

		// Merging palette settings:
		// t3lib_div::array_merge() MUST be used - otherwise the keys will be re-numbered!
	$TCA['pages']['palettes'] = t3lib_div::array_merge($TCA['pages']['palettes'],array(
		'1' => array('showitem' => 'starttime, endtime, extendToSubpages'),
		'2' => array('showitem' => 'layout, lastUpdated, newUntil, no_search'),
		'3' => array('showitem' => 'alias, target, no_cache, cache_timeout'),
		'5' => array('showitem' => 'author, author_email', 'canNotCollapse' => 1)
	));


	// if the compat version is less than 4.2, pagetype 2 ("Advanced")
	// and pagetype 5 ("Not in menu") are added to TCA.
	if (!t3lib_div::compat_version('4.2')) {
			// Merging in CMS doktypes
		array_splice(
			$TCA['pages']['columns']['doktype']['config']['items'],
			2,
			0,
			array(
				array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.0', '2', 'i/pages.gif'),
				array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.3', '5', 'i/pages_notinmenu.gif'),
			)
		);
			// setting the doktype 1 ("Standard") to show less fields
		$TCA['pages']['types'][1] = array(
				// standard
			'showitem' =>
					'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
					starttime, endtime, fe_group, extendToSubpages,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
					TSconfig;;6;nowrap;4-4-4, storage_pid;;7, l18n_cfg,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		');
			// adding doktype 2 ("Advanced")
		$TCA['pages']['types'][2] = array(
			'showitem' =>
					'doktype;;2;;1-1-1, hidden, nav_hide, title;;3;;2-2-2, subtitle, nav_title,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
					abstract;;5;;3-3-3, keywords, description,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
					media,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
					starttime, endtime, fe_login_mode, fe_group, extendToSubpages,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
					TSconfig;;6;nowrap;6-6-6, storage_pid;;7, l18n_cfg, module, content_from_pid,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		');
	}

// ******************************************************************
// This is the standard TypoScript content table, tt_content
// ******************************************************************
$TCA['tt_content'] = array (
	'ctrl' => array (
		'label' => 'header',
		'label_alt' => 'subheader,bodytext',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:tt_content',
		'delete' => 'deleted',
		'versioningWS' => 2,
		'versioning_followPages' => true,
		'origUid' => 't3_origuid',
		'type' => 'CType',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' => 'colPos,sys_language_uid',
		'useColumnsForDefaultValues' => 'colPos,sys_language_uid',
		'shadowColumnsForNewPlaceholders' => 'colPos',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'typeicon_column' => 'CType',
		'typeicons' => array (
			'header' => 'tt_content_header.gif',
			'textpic' => 'tt_content_textpic.gif',
			'image' => 'tt_content_image.gif',
			'bullets' => 'tt_content_bullets.gif',
			'table' => 'tt_content_table.gif',
			'splash' => 'tt_content_news.gif',
			'uploads' => 'tt_content_uploads.gif',
			'multimedia' => 'tt_content_mm.gif',
			'media' => 'tt_content_mm.gif',
			'menu' => 'tt_content_menu.gif',
			'list' => 'tt_content_list.gif',
			'mailform' => 'tt_content_form.gif',
			'search' => 'tt_content_search.gif',
			'login' => 'tt_content_login.gif',
			'shortcut' => 'tt_content_shortcut.gif',
			'script' => 'tt_content_script.gif',
			'div' => 'tt_content_div.gif',
			'html' => 'tt_content_html.gif'
		),
		'mainpalette' => '15',
		'thumbnail' => 'image',
		'requestUpdate' => 'list_type,rte_enabled',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_tt_content.php',
		'dividers2tabs' => 1
	)
);

// ******************************************************************
// fe_users
// ******************************************************************
$TCA['fe_users'] = array (
	'ctrl' => array (
		'label' => 'username',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'fe_cruser_id' => 'fe_cruser_id',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:fe_users',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'disable',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		),
		'useColumnsForDefaultValues' => 'usergroup,lockToDomain,disable,starttime,endtime',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'dividers2tabs' => 1
	),
	'feInterface' => array (
		'fe_admin_fieldList' => 'username,password,usergroup,name,address,telephone,fax,email,title,zip,city,country,www,company',
	)
);

// ******************************************************************
// fe_groups
// ******************************************************************
$TCA['fe_groups'] = array (
	'ctrl' => array (
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'enablecolumns' => array (
			'disabled' => 'hidden'
		),
		'title' => 'LLL:EXT:cms/locallang_tca.xml:fe_groups',
		'useColumnsForDefaultValues' => 'lockToDomain',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'dividers2tabs' => 1
	)
);

// ******************************************************************
// sys_domain
// ******************************************************************
$TCA['sys_domain'] = array (
	'ctrl' => array (
		'label' => 'domainName',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:sys_domain',
		'iconfile' => 'domain.gif',
		'enablecolumns' => array (
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php'
	)
);

// ******************************************************************
// pages_language_overlay
// ******************************************************************
$TCA['pages_language_overlay'] = array (
	'ctrl' => array (
		'label'                           => 'title',
		'tstamp'                          => 'tstamp',
		'title'                           => 'LLL:EXT:cms/locallang_tca.xml:pages_language_overlay',
		'versioningWS'                    => true,
		'versioning_followPages'          => true,
		'origUid'                         => 't3_origuid',
		'crdate'                          => 'crdate',
		'cruser_id'                       => 'cruser_id',
		'delete'                          => 'deleted',
		'enablecolumns'                   => array (
			'disabled'  => 'hidden',
			'starttime' => 'starttime',
			'endtime'   => 'endtime'
		),
		'transOrigPointerField'           => 'pid',
		'transOrigPointerTable'           => 'pages',
		'transOrigDiffSourceField'        => 'l18n_diffsource',
		'shadowColumnsForNewPlaceholders' => 'title',
		'languageField'                   => 'sys_language_uid',
		'mainpalette'                     => 1,
		'dynamicConfigFile'               => t3lib_extMgm::extPath($_EXTKEY) . 'tbl_cms.php',
		'type'                            => 'doktype',
		'dividers2tabs'                   => true
	)
);


// ******************************************************************
// sys_template
// ******************************************************************
$TCA['sys_template'] = array (
	'ctrl' => array (
		'label' => 'title',
		'tstamp' => 'tstamp',
		'sortby' => 'sorting',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:sys_template',
		'versioningWS' => true,
		'origUid' => 't3_origuid',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'adminOnly' => 1,	// Only admin, if any
		'iconfile' => 'template.gif',
		'thumbnail' => 'resources',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		),
		'typeicon_column' => 'root',
		'typeicons' => array (
			'0' => 'template_add.gif'
		),
		'dividers2tabs' => 1,
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php'
	)
);

// ******************************************************************
// static_template
// ******************************************************************
$TCA['static_template'] = array (
	'ctrl' => array (
		'label' => 'title',
		'tstamp' => 'tstamp',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:static_template',
		'readOnly' => 1,	// This should always be true, as it prevents the static templates from being altered
		'adminOnly' => 1,	// Only admin, if any
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY title',
		'crdate' => 'crdate',
		'iconfile' => 'template_standard.gif',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php'
	)
);


###########################
## EXTENSION: sv
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/sv/ext_tables.php
###########################

$_EXTKEY = 'sv';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['sv']['services'] = array(
		'title'       => 'LLL:EXT:sv/reports/locallang.xml:report_title',
		'description' => 'LLL:EXT:sv/reports/locallang.xml:report_description',
		'icon'		  => 'EXT:sv/reports/tx_sv_report.png',
		'report'      => 'tx_sv_reports_ServicesList'
	);
}

###########################
## EXTENSION: css_styled_content
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/css_styled_content/ext_tables.php
###########################

$_EXTKEY = 'css_styled_content';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


# TYPO3 SVN ID: $Id: ext_tables.php 5337 2009-04-21 08:49:20Z francois $
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// add flexform
t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:css_styled_content/flexform_ds.xml','table');
$TCA['tt_content']['types']['table']['showitem']='CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;4-4-4,
			--div--;LLL:EXT:cms/locallang_ttc.xml:CType.I.5, layout;;10;;3-3-3, cols, bodytext;;9;nowrap:wizards[table], text_properties, pi_flexform,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime';

t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'CSS Styled Content');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v3.8/', 'CSS Styled Content TYPO3 v3.8');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v3.9/', 'CSS Styled Content TYPO3 v3.9');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.2/', 'CSS Styled Content TYPO3 v4.2');


###########################
## EXTENSION: install
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/install/ext_tables.php
###########################

$_EXTKEY = 'install';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE') {
	t3lib_extMgm::addModule('tools', 'install', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['typo3'][] = 'tx_install_report_InstallStatus';
}


###########################
## EXTENSION: rtehtmlarea
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/rtehtmlarea/ext_tables.php
###########################

$_EXTKEY = 'rtehtmlarea';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

		// Add static template for Click-enlarge rendering
	t3lib_extMgm::addStaticFile($_EXTKEY,'static/clickenlarge/','Clickenlarge Rendering');

	$TCA['tx_rtehtmlarea_acronym'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:rtehtmlarea/locallang_db.xml:tx_rtehtmlarea_acronym',
		'label' => 'term',
		'default_sortby' => 'ORDER BY term',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => Array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'htmlarea/skins/default/images/Acronym/ed_acronym.gif',
		)
	);

	t3lib_extMgm::allowTableOnStandardPages('tx_rtehtmlarea_acronym');


###########################
## EXTENSION: t3skin
## FILE:      /var/www/vhosts/bhafc/www/typo3/sysext/t3skin/ext_tables.php
###########################

$_EXTKEY = 't3skin';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE' || (TYPO3_MODE == 'FE' && isset($GLOBALS['BE_USER']) && $GLOBALS['BE_USER']->isFrontendEditingActive())) {
	global $TBE_STYLES;

		// Support for other extensions to add own icons...
	$presetSkinImgs = is_array($TBE_STYLES['skinImg']) ?
		$TBE_STYLES['skinImg'] :
		array();

	/**
	 * Setting up backend styles and colors
	 */
	$TBE_STYLES['mainColors'] = array(	// Always use #xxxxxx color definitions!
		'bgColor'    => '#FFFFFF',		// Light background color
		'bgColor2'   => '#FEFEFE',		// Steel-blue
		'bgColor3'   => '#F1F3F5',		// dok.color
		'bgColor4'   => '#E6E9EB',		// light tablerow background, brownish
		'bgColor5'   => '#F8F9FB',		// light tablerow background, greenish
		'bgColor6'   => '#E6E9EB',		// light tablerow background, yellowish, for section headers. Light.
		'hoverColor' => '#FF0000',
		'navFrameHL' => '#F8F9FB'
	);

	$TBE_STYLES['colorschemes'][0] = '-|class-main1,-|class-main2,-|class-main3,-|class-main4,-|class-main5';
	$TBE_STYLES['colorschemes'][1] = '-|class-main11,-|class-main12,-|class-main13,-|class-main14,-|class-main15';
	$TBE_STYLES['colorschemes'][2] = '-|class-main21,-|class-main22,-|class-main23,-|class-main24,-|class-main25';
	$TBE_STYLES['colorschemes'][3] = '-|class-main31,-|class-main32,-|class-main33,-|class-main34,-|class-main35';
	$TBE_STYLES['colorschemes'][4] = '-|class-main41,-|class-main42,-|class-main43,-|class-main44,-|class-main45';
	$TBE_STYLES['colorschemes'][5] = '-|class-main51,-|class-main52,-|class-main53,-|class-main54,-|class-main55';

	$TBE_STYLES['styleschemes'][0]['all'] = 'CLASS: formField';
	$TBE_STYLES['styleschemes'][1]['all'] = 'CLASS: formField1';
	$TBE_STYLES['styleschemes'][2]['all'] = 'CLASS: formField2';
	$TBE_STYLES['styleschemes'][3]['all'] = 'CLASS: formField3';
	$TBE_STYLES['styleschemes'][4]['all'] = 'CLASS: formField4';
	$TBE_STYLES['styleschemes'][5]['all'] = 'CLASS: formField5';

	$TBE_STYLES['styleschemes'][0]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][1]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][2]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][3]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][4]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][5]['check'] = 'CLASS: checkbox';

	$TBE_STYLES['styleschemes'][0]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][1]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][2]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][3]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][4]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][5]['radio'] = 'CLASS: radio';

	$TBE_STYLES['styleschemes'][0]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][1]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][2]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][3]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][4]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][5]['select'] = 'CLASS: select';

	$TBE_STYLES['borderschemes'][0] = array('', '', '', 'wrapperTable');
	$TBE_STYLES['borderschemes'][1] = array('', '', '', 'wrapperTable1');
	$TBE_STYLES['borderschemes'][2] = array('', '', '', 'wrapperTable2');
	$TBE_STYLES['borderschemes'][3] = array('', '', '', 'wrapperTable3');
	$TBE_STYLES['borderschemes'][4] = array('', '', '', 'wrapperTable4');
	$TBE_STYLES['borderschemes'][5] = array('', '', '', 'wrapperTable5');



		// Setting the relative path to the extension in temp. variable:
	$temp_eP = t3lib_extMgm::extRelPath($_EXTKEY);

		// Setting login box image rotation folder:
	$TBE_STYLES['loginBoxImage_rotationFolder'] = $temp_eP.'images/login/';
	$TBE_STYLES['loginBoxImage_author']['loginimage_4_2.jpg'] = 'Photo by Photo by J.C. Franca (www.digitalphoto.com.br)';
#	$TBE_STYLES['loginBoxImage_rotationFolder'] = '';

		// Setting up stylesheets (See template() constructor!)
#	$TBE_STYLES['stylesheet']                   = $temp_eP.'stylesheets/stylesheet.css';			// Alternative stylesheet to the default "typo3/stylesheet.css" stylesheet.
#	$TBE_STYLES['stylesheet2']                  = $temp_eP.'stylesheets/stylesheet.css';			// Additional stylesheet (not used by default).  Set BEFORE any in-document styles
	$TBE_STYLES['styleSheetFile_post']          = $temp_eP.'stylesheets/stylesheet_post.css';		// Additional stylesheet. Set AFTER any in-document styles
#	$TBE_STYLES['inDocStyles_TBEstyle']         = '* {text-align: right;}';							// Additional default in-document styles.
	$TBE_STYLES['stylesheets']['modulemenu']    = $temp_eP.'stylesheets/modulemenu.css';
	$TBE_STYLES['stylesheets']['backend-style'] = $temp_eP.'stylesheets/backend-style.css';
	$TBE_STYLES['stylesheets']['admPanel'] = $temp_eP.'stylesheets/admPanel.css';

		// Alternative dimensions for frameset sizes:
	$TBE_STYLES['dims']['leftMenuFrameW'] = 160;		// Left menu frame width
	$TBE_STYLES['dims']['topFrameH']      = 45;			// Top frame heigth
	$TBE_STYLES['dims']['shortcutFrameH'] = 35;			// Shortcut frame height
	$TBE_STYLES['dims']['selMenuFrame']   = 200;		// Width of the selector box menu frame
	$TBE_STYLES['dims']['navFrameWidth']  = 260;		// Default navigation frame width

		// Setting roll-over background color for click menus:
		// Notice, this line uses the the 'scriptIDindex' feature to override another value in this array (namely $TBE_STYLES['mainColors']['bgColor5']), for a specific script "typo3/alt_clickmenu.php"
	$TBE_STYLES['scriptIDindex']['typo3/alt_clickmenu.php']['mainColors']['bgColor5'] = '#F8F9FB';

		// Setting up auto detection of alternative icons:
	$TBE_STYLES['skinImgAutoCfg'] = array(
		'absDir'             => t3lib_extMgm::extPath($_EXTKEY).'icons/',
		'relDir'             => t3lib_extMgm::extRelPath($_EXTKEY).'icons/',
		'forceFileExtension' => 'gif',	// Force to look for PNG alternatives...
#		'scaleFactor'        => 2/3,	// Scaling factor, default is 1
		'iconSizeWidth'      => 16,
		'iconSizeHeight'     => 16,
	);

		// Changing icon for filemounts, needs to be done here as overwriting the original icon would also change the filelist tree's root icon
	$TCA['sys_filemounts']['ctrl']['iconfile'] = '_icon_ftp_2.gif';

		// Manual setting up of alternative icons. This is mainly for module icons which has a special prefix:
	$TBE_STYLES['skinImg'] = array_merge($presetSkinImgs, array (
		'gfx/ol/blank.gif'                         => array('clear.gif','width="14" height="14"'),
		'MOD:web/website.gif'                      => array($temp_eP.'icons/module_web.gif','width="24" height="24"'),
		'MOD:web_layout/layout.gif'                => array($temp_eP.'icons/module_web_layout.gif','width="24" height="24"'),
		'MOD:web_view/view.gif'                    => array($temp_eP.'icons/module_web_view.gif','width="24" height="24"'),
		'MOD:web_list/list.gif'                    => array($temp_eP.'icons/module_web_list.gif','width="24" height="24"'),
		'MOD:web_info/info.gif'                    => array($temp_eP.'icons/module_web_info.gif','width="24" height="24"'),
		'MOD:web_perm/perm.gif'                    => array($temp_eP.'icons/module_web_perms.gif','width="24" height="24"'),
		'MOD:web_perm/legend.gif'                  => array($temp_eP.'icons/legend.gif','width="24" height="24"'),
		'MOD:web_func/func.gif'                    => array($temp_eP.'icons/module_web_func.gif','width="24" height="24"'),
		'MOD:web_ts/ts1.gif'                       => array($temp_eP.'icons/module_web_ts.gif','width="24" height="24"'),
		'MOD:web_modules/modules.gif'              => array($temp_eP.'icons/module_web_modules.gif','width="24" height="24"'),
		'MOD:web_txversionM1/cm_icon.gif'          => array($temp_eP.'icons/module_web_version.gif','width="24" height="24"'),
		'MOD:file/file.gif'                        => array($temp_eP.'icons/module_file.gif','width="22" height="24"'),
		'MOD:file_list/list.gif'                   => array($temp_eP.'icons/module_file_list.gif','width="22" height="24"'),
		'MOD:file_images/images.gif'               => array($temp_eP.'icons/module_file_images.gif','width="22" height="22"'),
		'MOD:user/user.gif'                        => array($temp_eP.'icons/module_user.gif','width="22" height="22"'),
		'MOD:user_task/task.gif'                   => array($temp_eP.'icons/module_user_taskcenter.gif','width="22" height="22"'),
		'MOD:user_setup/setup.gif'                 => array($temp_eP.'icons/module_user_setup.gif','width="22" height="22"'),
		'MOD:user_doc/document.gif'                => array($temp_eP.'icons/module_doc.gif','width="22" height="22"'),
		'MOD:user_ws/sys_workspace.gif'            => array($temp_eP.'icons/module_user_ws.gif','width="22" height="22"'),
		'MOD:tools/tool.gif'                       => array($temp_eP.'icons/module_tools.gif','width="25" height="24"'),
		'MOD:tools_beuser/beuser.gif'              => array($temp_eP.'icons/module_tools_user.gif','width="24" height="24"'),
		'MOD:tools_em/em.gif'                      => array($temp_eP.'icons/module_tools_em.gif','width="24" height="24"'),
		'MOD:tools_em/install.gif'                 => array($temp_eP.'icons/module_tools_em.gif','width="24" height="24"'),
		'MOD:tools_dbint/db.gif'                   => array($temp_eP.'icons/module_tools_dbint.gif','width="25" height="24"'),
		'MOD:tools_config/config.gif'              => array($temp_eP.'icons/module_tools_config.gif','width="24" height="24"'),
		'MOD:tools_install/install.gif'            => array($temp_eP.'icons/module_tools_install.gif','width="24" height="24"'),
		'MOD:tools_log/log.gif'                    => array($temp_eP.'icons/module_tools_log.gif','width="24" height="24"'),
		'MOD:tools_txphpmyadmin/thirdparty_db.gif' => array($temp_eP.'icons/module_tools_phpmyadmin.gif','width="24" height="24"'),
		'MOD:tools_isearch/isearch.gif'            => array($temp_eP.'icons/module_tools_isearch.gif','width="24" height="24"'),
		'MOD:help/help.gif'                        => array($temp_eP.'icons/module_help.gif','width="23" height="24"'),
		'MOD:help_about/info.gif'                  => array($temp_eP.'icons/module_help_about.gif','width="25" height="24"'),
		'MOD:help_aboutmodules/aboutmodules.gif'   => array($temp_eP.'icons/module_help_aboutmodules.gif','width="24" height="24"'),
		'MOD:help_cshmanual/about.gif'         => array($temp_eP.'icons/module_help_cshmanual.gif','width="25" height="24"'),
		'MOD:help_txtsconfighelpM1/moduleicon.gif' => array($temp_eP.'icons/module_help_ts.gif','width="25" height="24"'),
	));

		// Adding icon for photomarathon extensions' backend module, if enabled:
	if (t3lib_extMgm::isloaded('user_photomarathon'))	{
		$TBE_STYLES['skinImg']['MOD:web_uphotomarathon/tab_icon.gif'] = array($temp_eP.'icons/ext/user_photomarathon/tab_icon.gif','width="24" height="24"');
	}
		// Adding icon for templavoila extensions' backend module, if enabled:
	if (t3lib_extMgm::isloaded('templavoila'))	{
		$TBE_STYLES['skinImg']['MOD:web_txtemplavoilaM1/moduleicon.gif'] = array($temp_eP.'icons/ext/templavoila/mod1/moduleicon.gif','width="22" height="22"');
		$TBE_STYLES['skinImg']['MOD:web_txtemplavoilaM2/moduleicon.gif'] = array($temp_eP.'icons/ext/templavoila/mod1/moduleicon.gif','width="22" height="22"');
	}
		// Adding icon for extension manager' backend module, if enabled:
	$TBE_STYLES['skinImg']['MOD:tools_em/install.gif']   = array($temp_eP.'icons/ext/templavoila/mod1/moduleicon.gif','width="22" height="22"');
	$TBE_STYLES['skinImg']['MOD:tools_em/uninstall.gif'] = array($temp_eP.'icons/ext/templavoila/mod1/moduleicon.gif','width="22" height="22"');

		// extJS theme
	$TBE_STYLES['extJS']['theme'] =  $temp_eP . 'extjs/xtheme-t3skin.css';

	//print_a($TBE_STYLES,2);

	// Adding HTML template for login screen
	$TBE_STYLES['htmlTemplates']['templates/login.html'] = 'sysext/t3skin/templates/login.html';

	$GLOBALS['TYPO3_CONF_VARS']['typo3/backend.php']['additionalBackendItems'][] = t3lib_extMgm::extPath('t3skin').'registerIe6Stylesheet.php';

}


###########################
## EXTENSION: realurl
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/realurl/ext_tables.php
###########################

$_EXTKEY = 'realurl';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
//	t3lib_extMgm::addModule('tools','txrealurlM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');

	// Add Web>Info module:
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_realurl_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY) . 'modfunc1/class.tx_realurl_modfunc1.php',
		'LLL:EXT:realurl/locallang_db.xml:moduleFunction.tx_realurl_modfunc1',
		'function',
		'online'
	);
}

$TCA['pages']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'displayCond' => 'FIELD:tx_realurl_exclude:!=:1',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 60,
			'eval' => 'trim,nospace,lower'
			//'eval' => 'uniqueInPid'	// DON'T use this anyway, it is very confusing when a path is automatically set!
		),
	),
	'tx_realurl_exclude' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_exclude',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', ''),
			),
		),
	),
);

if (t3lib_div::compat_version('4.2')) {
	// For 4.2 or new add fields to advanced page only
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment,tx_realurl_exclude', '1', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment,tx_realurl_exclude', '4,254', 'after:title');
}
else {
	// Put it for standard page
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment,tx_realurl_exclude', '2', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment,tx_realurl_exclude', '1,5,4,254', 'after:title');
}

$TCA['pages_language_overlay']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 60,
			'eval' => 'trim,nospace,lower'
		),
	),
);

t3lib_extMgm::addToAllTCAtypes('pages_language_overlay', 'tx_realurl_pathsegment', '', 'after:nav_title');


###########################
## EXTENSION: kickstarter
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/kickstarter/ext_tables.php
###########################

$_EXTKEY = 'kickstarter';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

if (TYPO3_MODE=="BE")	{
	t3lib_extMgm::insertModuleFunction(
		"tools_em",
		"tx_kickstarter_modfunc1",
		t3lib_extMgm::extPath($_EXTKEY)."modfunc1/class.tx_kickstarter_modfunc1.php",
		"LLL:EXT:kickstarter/locallang_db.xml:moduleFunction.tx_kickstarter_modfunc1"
	);
	t3lib_extMgm::insertModuleFunction(
		"tools_em",
		"tx_kickstarter_modfunc2",
		t3lib_extMgm::extPath($_EXTKEY)."modfunc1/class.tx_kickstarter_modfunc1.php",
		"LLL:EXT:kickstarter/locallang_db.xml:moduleFunction.tx_kickstarter_modfunc2",
		'singleDetails'
	);
}

###########################
## EXTENSION: bhafc_browser_titles
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/bhafc_browser_titles/ext_tables.php
###########################

$_EXTKEY = 'bhafc_browser_titles';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:bhafc_browser_titles/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: static_info_tables
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/static_info_tables/ext_tables.php
###########################

$_EXTKEY = 'static_info_tables';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addStaticFile(STATIC_INFO_TABLES_EXTkey, 'static/static_info_tables/', 'Static Info tables');

$TCA['static_territories'] = array(
	'ctrl' => array(
		'label' => 'tr_name_en',
		'label_alt' => 'tr_name_en,tr_iso_nr',
		'readOnly' => 1,	// This should always be true, as it prevents the static data from being altered
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY tr_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_territories.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_territories.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'tr_name_en,tr_iso_nr'
	)
);

// Country reference data from ISO 3166-1
$TCA['static_countries'] = array(
	'ctrl' => array(
		'label' => 'cn_short_en',
		'label_alt' => 'cn_short_en,cn_iso_2',
		'readOnly' => 1,	// This should always be true, as it prevents the static data from being altered
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY cn_short_en',
		'delete' => 'deleted',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_countries.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_countries.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'cn_iso_2,cn_iso_3,cn_iso_nr,cn_official_name_local,cn_official_name_en,cn_capital,cn_tldomain,cn_currency_iso_3,cn_currency_iso_nr,cn_phone,cn_uno_member,cn_eu_member,cn_address_format,cn_short_en'
	)
);

// Country subdivision reference data from ISO 3166-2
$TCA['static_country_zones'] = array(
	'ctrl' => array(
		'label' => 'zn_name_local',
		'label_alt' => 'zn_name_local,zn_code',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY zn_name_local',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_country_zones.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_countries.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'zn_country_iso_nr,zn_country_iso_3,zn_code,zn_name_local,zn_name_en'
	)
);

// Language reference data from ISO 639-1
$TCA['static_languages'] = array(
	'ctrl' => array(
		'label' => 'lg_name_en',
		'label_alt' => 'lg_name_en,lg_iso_2',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY lg_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_languages.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_languages.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'lg_name_local,lg_name_en,lg_iso_2,lg_typo3,lg_country_iso_2,lg_collate_locale,lg_sacred,lg_constructed'
	)
);

// Currency reference data from ISO 4217
$TCA['static_currencies'] = array(
	'ctrl' => array(
		'label' => 'cu_name_en',
		'label_alt' => 'cu_name_en,cu_iso_3',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY cu_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_currencies.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_currencies.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'cu_iso_3,cu_iso_nr,cu_name_en,cu_symbol_left,cu_symbol_right,cu_thousands_point,cu_decimal_point,cu_decimal_digits,cu_sub_name_en,cu_sub_divisor,cu_sub_symbol_left,cu_sub_symbol_right'
	)
);

// Static markets from ISO 10383
$TCA['static_markets'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_markets.title',
		'label'     => 'institution_description',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY institution_description',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile'          => PATH_BE_staticinfotables_rel.'icon_static_markets.gif',
	),
	'interface' => Array (
		'showRecordFieldList' => 'country,mic,institution_description,acronym,city,url',
	)
);

$TCA['static_countries']['ctrl']['readOnly'] = 0;
$TCA['static_languages']['ctrl']['readOnly'] = 0;
$TCA['static_country_zones']['ctrl']['readOnly'] = 0;
$TCA['static_currencies']['ctrl']['readOnly'] = 0;
$TCA['static_territories']['ctrl']['readOnly'] = 0;
$TCA['static_markets']['ctrl']['readOnly'] = 0;


// ******************************************************************
// sys_language
// ******************************************************************

t3lib_div::loadTCA('sys_language');
$TCA['sys_language']['columns']['static_lang_isocode']['config'] = array(
	'type' => 'select',
	'items' => array(
		array('',0),
	),
	#'foreign_table' => 'static_languages',
	#'foreign_table_where' => 'AND static_languages.pid=0 ORDER BY static_languages.lg_name_en',
	'itemsProcFunc' => 'tx_staticinfotables_div->selectItemsTCA',
	'itemsProcFunc_config' => array(
		'table' => 'static_languages',
		'indexField' => 'uid',
		// I think that will make more sense in the future
		// 'indexField' => 'lg_iso_2',
		'prependHotlist' => 1,
		//	defaults:
		//'hotlistLimit' => 8,
		//'hotlistSort' => 1,
		//'hotlistOnly' => 0,
		//'hotlistApp' => TYPO3_MODE,
	),
	'size' => 1,
	'minitems' => 0,
	'maxitems' => 1,
);

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:'.STATIC_INFO_TABLES_EXTkey.'/class.tx_staticinfotables_syslanguage.php:&tx_staticinfotables_syslanguage';


###########################
## EXTENSION: templavoila
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/templavoila/ext_tables.php
###########################

$_EXTKEY = 'templavoila';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


# TYPO3 CVS ID: $Id: ext_tables.php 26531 2009-11-14 15:37:41Z tolleiv $
if (!defined ('TYPO3_MODE'))  die ('Access denied.');

// unserializing the configuration so we can use it here:
$_EXTCONF = unserialize($_EXTCONF);

if (TYPO3_MODE=='BE') {

		// Adding click menu item:
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_templavoila_cm1',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_templavoila_cm1.php'
	);
	include_once(t3lib_extMgm::extPath('templavoila').'class.tx_templavoila_handlestaticdatastructures.php');

		// Adding backend modules:
	t3lib_extMgm::addModule('web','txtemplavoilaM1','top',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
	t3lib_extMgm::addModule('web','txtemplavoilaM2','',t3lib_extMgm::extPath($_EXTKEY).'mod2/');

		// Remove default Page module (layout) manually if wanted:
	if (!$_EXTCONF['enable.']['oldPageModule']) {
		$tmp = $GLOBALS['TBE_MODULES']['web'];
		$GLOBALS['TBE_MODULES']['web'] = str_replace (',,',',',str_replace ('layout','',$tmp));
		unset ($GLOBALS['TBE_MODULES']['_PATHS']['web_layout']);
	}

		// Registering CSH:
	t3lib_extMgm::addLLrefForTCAdescr('be_groups','EXT:templavoila/locallang_csh_begr.xml');
	t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:templavoila/locallang_csh_pages.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tt_content','EXT:templavoila/locallang_csh_ttc.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tx_templavoila_datastructure','EXT:templavoila/locallang_csh_ds.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tx_templavoila_tmplobj','EXT:templavoila/locallang_csh_to.xml');
	t3lib_extMgm::addLLrefForTCAdescr('xMOD_tx_templavoila','EXT:templavoila/locallang_csh_module.xml');
	t3lib_extMgm::addLLrefForTCAdescr('xEXT_templavoila','EXT:templavoila/locallang_csh_intro.xml');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_txtemplavoilaM1','EXT:templavoila/locallang_csh_pm.xml');


	t3lib_extMgm::insertModuleFunction(
		'tools_txextdevevalM1',
		'tx_templavoila_extdeveval',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_templavoila_extdeveval.php',
		'TemplaVoila L10N Mode Conversion Tool'
	);
}

	// Adding tables:
$TCA['tx_templavoila_tmplobj'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:templavoila/locallang_db.xml:tx_templavoila_tmplobj',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY title',
		'delete' => 'deleted',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_to.gif',
		'selicon_field' => 'previewicon',
		'selicon_field_path' => 'uploads/tx_templavoila',
		'type' => 'parent',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'title,datastructure,rendertype,sys_language_uid,parent,rendertype_ref',
	)
);
$TCA['tx_templavoila_datastructure'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:templavoila/locallang_db.xml:tx_templavoila_datastructure',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY title',
		'delete' => 'deleted',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_ds.gif',
		'selicon_field' => 'previewicon',
		'selicon_field_path' => 'uploads/tx_templavoila',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'scope,title',
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_templavoila_datastructure');
t3lib_extMgm::allowTableOnStandardPages('tx_templavoila_tmplobj');


	// Adding access list to be_groups
t3lib_div::loadTCA('be_groups');
$tempColumns = array (
	'tx_templavoila_access' => array(
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:be_groups.tx_templavoila_access',
		'config' => Array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_templavoila_datastructure,tx_templavoila_tmplobj',
			'prepend_tname' => 1,
			'size' => 5,
			'autoSizeMax' => 15,
			'multiple' => 1,
			'minitems' => 0,
			'maxitems' => 1000,
			'show_thumbs'=> 1,
		),
	)
);
t3lib_extMgm::addTCAcolumns('be_groups', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('be_groups','tx_templavoila_access;;;;1-1-1', '1');

	// Adding the new content element, "Flexible Content":
t3lib_div::loadTCA('tt_content');
$tempColumns = array(
	'tx_templavoila_ds' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_ds',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_templavoila_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_to',
		'displayCond' => 'FIELD:CType:=:' . $_EXTKEY . '_pi1',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_templavoila_flex' => Array (
		'l10n_cat' => 'text',
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_flex',
		'displayCond' => 'FIELD:tx_templavoila_ds:REQ:true',
		'config' => Array (
			'type' => 'flex',
			'ds_pointerField' => 'tx_templavoila_ds',
			'ds_tableField' => 'tx_templavoila_datastructure:dataprot',
		)
	),
	'tx_templavoila_pito' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_pito',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->pi_templates',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
);
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);

$TCA['tt_content']['ctrl']['typeicons'][$_EXTKEY . '_pi1'] = t3lib_extMgm::extRelPath($_EXTKEY) . '/icon_fce_ce.png';
t3lib_extMgm::addPlugin(array('LLL:EXT:templavoila/locallang_db.xml:tt_content.CType_pi1', $_EXTKEY . '_pi1', 'EXT:' . $_EXTKEY . '/icon_fce_ce.png'), 'CType');

if ($_EXTCONF['enable.']['selectDataSource']) {
	$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = 'CType;;4;button;1-1-1, header;;3;;2-2-2,tx_templavoila_ds,tx_templavoila_to,tx_templavoila_flex;;;;2-2-2, hidden;;1;;3-3-3';
	if ($TCA['tt_content']['ctrl']['requestUpdate'] != '') {
		$TCA['tt_content']['ctrl']['requestUpdate'] .= ',';
	}
	$TCA['tt_content']['ctrl']['requestUpdate'] .= 'tx_templavoila_ds';
}
else {
	$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] = 'CType;;4;button;1-1-1, header;;3;;2-2-2,tx_templavoila_to,tx_templavoila_flex;;;;2-2-2, hidden;;1;;3-3-3';
}

	// For pages:
$tempColumns = array (
	'tx_templavoila_ds' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_ds',
		'config' => array (
			'type' => 'select',
			'items' => Array (
				array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'IF_VALUE_FALSE',
		)
	),
	'tx_templavoila_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_to',
		'displayCond' => 'FIELD:tx_templavoila_ds:REQ:true',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_templavoila_next_ds' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_next_ds',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'IF_VALUE_FALSE',
		)
	),
	'tx_templavoila_next_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_next_to',
		'displayCond' => 'FIELD:tx_templavoila_next_ds:REQ:true',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_templavoila_flex' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_flex',
		'config' => Array (
			'type' => 'flex',
			'ds_pointerField' => 'tx_templavoila_ds',
			'ds_pointerField_searchParent' => 'pid',
			'ds_pointerField_searchParent_subField' => 'tx_templavoila_next_ds',
			'ds_tableField' => 'tx_templavoila_datastructure:dataprot',
		)
	),
);
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
if ($_EXTCONF['enable.']['selectDataSource']) {
	t3lib_extMgm::addToAllTCAtypes('pages','tx_templavoila_ds;;;;1-1-1,tx_templavoila_to,tx_templavoila_nextds;;;;1-1-1,tx_templavoila_next_to,tx_templavoila_flex;;;;1-1-1');
	if ($TCA['pages']['ctrl']['requestUpdate'] != '') {
		$TCA['pages']['ctrl']['requestUpdate'] .= ',';
	}
	$TCA['pages']['ctrl']['requestUpdate'] .= 'tx_templavoila_ds,tx_templavoila_next_ds';
}
else {
	t3lib_extMgm::addToAllTCAtypes('pages','tx_templavoila_to;;;;1-1-1,tx_templavoila_next_to;;;;1-1-1,tx_templavoila_flex;;;;1-1-1');
	unset($TCA['pages']['columns']['tx_templavoila_to']['displayCond']);
	unset($TCA['pages']['columns']['tx_templavoila_next_to']['displayCond']);
}

	// Configure the referencing wizard to be used in the web_func module:
if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_templavoila_referenceElementsWizard',
		t3lib_extMgm::extPath($_EXTKEY).'func_wizards/class.tx_templavoila_referenceelementswizard.php',
		'LLL:EXT:templavoila/locallang.xml:wiz_refElements',
		'wiz'
	);
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_func','EXT:wizard_crpages/locallang_csh.xml');
}


###########################
## EXTENSION: loginbox_macmade
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/loginbox_macmade/ext_tables.php
###########################

$_EXTKEY = 'loginbox_macmade';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if( !defined( 'TYPO3_MODE' ) ) {
    die( 'Access denied.' );
}

// Load content TCA
t3lib_div::loadTCA( 'tt_content' );

// Plugin options
$TCA[ 'tt_content' ][ 'types' ][ 'list' ][ 'subtypes_excludelist' ] [$_EXTKEY . '_pi1' ] = 'layout,select_key,pages,recursive';

// Add flexform field to plugin options
$TCA[ 'tt_content' ][ 'types' ][ 'list' ][ 'subtypes_addlist' ][ $_EXTKEY . '_pi1' ] = 'pi_flexform';

// Add flexform DataStructure
t3lib_extMgm::addPiFlexFormValue(
    $_EXTKEY . '_pi1',
    'FILE:EXT:' . $_EXTKEY . '/flexform_ds_pi1.xml'
);

// Add plugin
t3lib_extMgm::addPlugin(
    array(
        'LLL:EXT:loginbox_macmade/locallang_db.php:tt_content.list_type_pi1',
        $_EXTKEY . '_pi1'
    ),
    'list_type'
);

// Wizard icons
if( TYPO3_MODE == 'BE' ) {
    $TBE_MODULES_EXT[ 'xMOD_db_new_content_el' ][ 'addElClasses' ][ 'tx_loginboxmacmade_pi1_wizicon' ] = t3lib_extMgm::extPath( $_EXTKEY )
                                                                                                       . 'pi1/class.tx_loginboxmacmade_pi1_wizicon.php';
}

###########################
## EXTENSION: se_registration
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/se_registration/ext_tables.php
###########################

$_EXTKEY = 'se_registration';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_seregistration_surname' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_surname',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_gender' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_gender',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_dob' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_dob',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_school' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_school',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_parent_name' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_parent_name',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_play_for' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_play_for',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_season_ticket' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_season_ticket',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_fav_player' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_fav_player',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
	'tx_seregistration_additional_material' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:se_registration/locallang_db.xml:fe_users.tx_seregistration_additional_material',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'trim',
		)
	),
);


t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','tx_seregistration_surname;;;;1-1-1, tx_seregistration_gender, tx_seregistration_dob, tx_seregistration_school, tx_seregistration_parent_name, tx_seregistration_play_for, tx_seregistration_season_ticket, tx_seregistration_fav_player, tx_seregistration_additional_material');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:se_registration/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:se_registration/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_about_gully
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_about_gully/ext_tables.php
###########################

$_EXTKEY = 'gg_about_gully';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_about_gully/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_about_gully/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_panels
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_panels/ext_tables.php
###########################

$_EXTKEY = 'gg_panels';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi5']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi5',
	$_EXTKEY . '_pi5',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi6']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi6',
	$_EXTKEY . '_pi6',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi7']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi7',
	$_EXTKEY . '_pi7',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi8']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi8',
	$_EXTKEY . '_pi8',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi9']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi9',
	$_EXTKEY . '_pi9',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi10']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi10',
	$_EXTKEY . '_pi10',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi11']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi11',
	$_EXTKEY . '_pi11',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi12']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_panels/locallang_db.xml:tt_content.list_type_pi12',
	$_EXTKEY . '_pi12',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_twitter
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_twitter/ext_tables.php
###########################

$_EXTKEY = 'gg_twitter';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_twitter/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_twitter/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_twitter/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_meet_the_team
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_meet_the_team/ext_tables.php
###########################

$_EXTKEY = 'gg_meet_the_team';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_meet_the_team/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_meet_the_team/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_meet_the_team/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggmeettheteam_players'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_meet_the_team/locallang_db.xml:tx_ggmeettheteam_players',		
		'label'     => 'lastname',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggmeettheteam_players.gif',
	),
);

###########################
## EXTENSION: gg_drawings
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_drawings/ext_tables.php
###########################

$_EXTKEY = 'gg_drawings';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_drawings/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_message_board
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_message_board/ext_tables.php
###########################

$_EXTKEY = 'gg_message_board';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_message_board/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggmessageboard_message'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_message_board/locallang_db.xml:tx_ggmessageboard_message',		
		'label'     => 'message',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY uid DESC',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggmessageboard_message.gif',
	),
);

###########################
## EXTENSION: gg_photos
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_photos/ext_tables.php
###########################

$_EXTKEY = 'gg_photos';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_photos/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggphotos_uploads'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_uploads',		
		'label'     => 'user_uid',	
		'label_userFunc'     => 'EXT:gg_photos/lib/class.tx_ggphotos_image_display.php:&tx_ggphotos_image_display->get_image_title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',	
		'default_sortby' => 'ORDER BY uid DESC',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggphotos_uploads.gif',
	),
);
$TBE_STYLES['stylesheet2'] = t3lib_extMgm::extRelPath($_EXTKEY).'/css/hidden_different.css';
$TCA['tx_ggphotos_featured'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_photos/locallang_db.xml:tx_ggphotos_featured',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggphotos_featured.gif',
	),
);

###########################
## EXTENSION: gg_the_score
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_the_score/ext_tables.php
###########################

$_EXTKEY = 'gg_the_score';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_the_score/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_the_score/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_the_score/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_the_score/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi5']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_the_score/locallang_db.xml:tt_content.list_type_pi5',
	$_EXTKEY . '_pi5',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggthescore_match'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_the_score/locallang_db.xml:tx_ggthescore_match',		
		'label'     => 'opposition',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggthescore_match.gif',
	),
);

###########################
## EXTENSION: gg_skills
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_skills/ext_tables.php
###########################

$_EXTKEY = 'gg_skills';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_ggskills_videos'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_skills/locallang_db.xml:tx_ggskills_videos',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggskills_videos.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_skills/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: tt_news
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/tt_news/ext_tables.php
###########################

$_EXTKEY = 'tt_news';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


/**
 * $Id: ext_tables.php 26984 2009-11-25 16:26:26Z rupi $
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
	// get extension configuration
$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['tt_news']);





$TCA['tt_news'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:tt_news/locallang_tca.xml:tt_news',
		'label' => ($confArr['label']) ? $confArr['label'] : 'title',
		'label_alt' => $confArr['label_alt'] . ($confArr['label_alt2'] ? ',' . $confArr['label_alt2'] : ''),
		'label_alt_force' => $confArr['label_alt_force'],
		'default_sortby' => 'ORDER BY datetime DESC',
		'prependAtCopy' => $confArr['prependAtCopy'] ? 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy' : '',
 		'versioningWS' => TRUE,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent,starttime,endtime,fe_group',

		'dividers2tabs' => TRUE,
		'useColumnsForDefaultValues' => 'type',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'crdate' => 'crdate',
		'tstamp' => 'tstamp',
		'delete' => 'deleted',
		'type' => 'type',
		'cruser_id' => 'cruser_id',
		'editlock' => 'editlock',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'typeicon_column' => 'type',
		'typeicons' => array (
			'1' => t3lib_extMgm::extRelPath($_EXTKEY).'res/gfx/tt_news_article.gif',
			'2' => t3lib_extMgm::extRelPath($_EXTKEY).'res/gfx/tt_news_exturl.gif',
		),
//		'mainpalette' => '10',
		'thumbnail' => 'image',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'res/gfx/ext_icon.gif',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php'
	)
);


#$category_OrderBy = $confArr['category_OrderBy'];
$TCA['tt_news_cat'] = array (
	'ctrl' => array (
		'title' => 'LLL:EXT:tt_news/locallang_tca.xml:tt_news_cat',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'delete' => 'deleted',
		'default_sortby' => 'ORDER BY uid',
		'treeParentField' => 'parent_category',
		'dividers2tabs' => TRUE,
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
// 		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'hideAtCopy' => true,
		'mainpalette' => '2,10',
		'crdate' => 'crdate',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'res/gfx/tt_news_cat.gif',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php'
	)
);

	// load tt_content to $TCA array
t3lib_div::loadTCA('tt_content');
	// remove some fields from the tt_content content element
$TCA['tt_content']['types']['list']['subtypes_excludelist'][9] = 'layout,select_key,pages,recursive';
	// add FlexForm field to tt_content
$TCA['tt_content']['types']['list']['subtypes_addlist'][9] = 'pi_flexform';
	// add tt_news to the "insert plugin" content element (list_type = 9)
t3lib_extMgm::addPlugin(array('LLL:EXT:tt_news/locallang_tca.xml:tt_news', 9));

t3lib_extMgm::addTypoScriptSetup('
  includeLibs.ts_news = EXT:tt_news/pi/class.tx_ttnews.php
  plugin.tt_news = USER
  plugin.tt_news {
    userFunc = tx_ttnews->main_news

    # validate some configuration values and display a message if errors have been found
    enableConfigValidation = 1
  }
');

	// initialize static extension templates
t3lib_extMgm::addStaticFile($_EXTKEY,'pi/static/ts_new/','News settings');
t3lib_extMgm::addStaticFile($_EXTKEY,'pi/static/css/','News CSS-styles');
//t3lib_extMgm::addStaticFile($_EXTKEY,'pi/static/ts_old/','table-based tmpl');
t3lib_extMgm::addStaticFile($_EXTKEY,'pi/static/rss_feed/','News feeds (RSS,RDF,ATOM)');

	// allow news and news-category records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tt_news_cat');
t3lib_extMgm::allowTableOnStandardPages('tt_news');
	// add the tt_news record to the insert records content element
t3lib_extMgm::addToInsertRecords('tt_news');

	// switch the XML files for the FlexForm depending on if "use StoragePid"(general record Storage Page) is set or not.
if ($confArr['useStoragePid']) {
	t3lib_extMgm::addPiFlexFormValue(9, 'FILE:EXT:tt_news/flexform_ds.xml');
} else {
	t3lib_extMgm::addPiFlexFormValue(9, 'FILE:EXT:tt_news/flexform_ds_no_sPID.xml');
}


t3lib_extMgm::addPageTSConfig('
	# RTE mode in table "tt_news"
	RTE.config.tt_news.bodytext.proc.overruleMode = ts_css

	TCEFORM.tt_news.bodytext.RTEfullScreenWidth = 100%



mod.web_txttnewsM1 {
	catmenu {
		expandFirst = 1

		show {
			cb_showEditIcons = 1
			cb_expandAll = 1
			cb_showHiddenCategories = 1

			btn_newCategory = 1
		}
	}
	list {
		limit = 15
		pidForNewArticles =
		fList = pid,uid,title,datetime,archivedate,tstamp,category;author
		icon = 1

		# configures the behavior of the record-title link. Possible values:
		# edit: link editform, view: link FE singleView, any other value: no link
		clickTitleMode = edit

		noListWithoutCatSelection = 1

		show {
			cb_showOnlyEditable = 1
			cb_showThumbs = 1
			search = 1

		}
		imageSize = 50

	}
	defaultLanguageLabel =
}



');




	// initalize "context sensitive help" (csh)
t3lib_extMgm::addLLrefForTCAdescr('tt_news','EXT:tt_news/csh/locallang_csh_ttnews.php');
t3lib_extMgm::addLLrefForTCAdescr('tt_news_cat','EXT:tt_news/csh/locallang_csh_ttnewscat.php');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_tt_news','EXT:tt_news/csh/locallang_csh_manual.xml');
t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_txttnewsM1','EXT:tt_news/csh/locallang_csh_mod_newsadmin.xml');

//TODO how to insert CSH to the be_users table ???

	// adds processing for extra "codes" that have been added to the "what to display" selector in the content element by other extensions
include_once(t3lib_extMgm::extPath($_EXTKEY).'lib/class.tx_ttnews_itemsProcFunc.php');
	// class for displaying the category tree in BE forms.
include_once(t3lib_extMgm::extPath($_EXTKEY).'lib/class.tx_ttnews_TCAform_selectTree.php');
	// class that uses hooks in class.t3lib_tcemain.php (processDatamapClass and processCmdmapClass)
	// to prevent not allowed "commands" (copy,delete,...) for a certain BE usergroup
include_once(t3lib_extMgm::extPath($_EXTKEY).'lib/class.tx_ttnews_tcemain.php');





$tempColumns = array (
		'tt_news_categorymounts' => array (
			'exclude' => 1,
		#	'l10n_mode' => 'exclude', // the localizalion mode will be handled by the userfunction
			'label' => 'LLL:EXT:tt_news/locallang_tca.xml:tt_news.categorymounts',
			'config' => array (


				'type' => 'select',
				'form_type' => 'user',
				'userFunc' => 'tx_ttnews_TCAform_selectTree->renderCategoryFields',
				'treeView' => 1,
				'foreign_table' => 'tt_news_cat',
				#'foreign_table_where' => $fTableWhere.'ORDER BY tt_news_cat.'.$confArr['category_OrderBy'],
				'size' => 3,
				'minitems' => 0,
				'maxitems' => 500,
// 				'MM' => 'tt_news_cat_mm',

			)
		),
// 		'tt_news_cmounts_usesubcats' => array (
// 			'exclude' => 1,
// 			'label' => 'LLL:EXT:tt_news/locallang_tca.xml:tt_news.cmounts_usesubcats',
// 			'config' => array (
// 				'type' => 'check'
// 			)
// 		),
);


t3lib_div::loadTCA('be_groups');
t3lib_extMgm::addTCAcolumns('be_groups',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('be_groups','tt_news_categorymounts;;;;1-1-1');

$tempColumns['tt_news_categorymounts']['displayCond'] = 'FIELD:admin:=:0';
// $tempColumns['tt_news_cmounts_usesubcats']['displayCond'] = 'FIELD:admin:=:0';


t3lib_div::loadTCA('be_users');
t3lib_extMgm::addTCAcolumns('be_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('be_users','tt_news_categorymounts;;;;1-1-1');



if (TYPO3_MODE == 'BE')	{
	if (t3lib_div::int_from_ver(TYPO3_version) >= 4000000) {
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4002000) {
			t3lib_extMgm::addModule('web','txttnewsM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');

			$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables'][$_EXTKEY][0]['fList'] = 'uid,title,author,category,datetime,archivedate,tstamp';
			$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables'][$_EXTKEY][0]['icon'] = TRUE;


		} else {
			/**
			 * @deprecated
			 * this module will be removed completely in future versions
			 */
			t3lib_extMgm::insertModuleFunction(
				'web_info',
				'tx_ttnewscatmanager_modfunc1',
				t3lib_extMgm::extPath($_EXTKEY).'modfunc1/class.tx_ttnewscatmanager_modfunc1.php',
				'LLL:EXT:tt_news/modfunc1/locallang.xml:moduleFunction.tx_ttnews_modfunc1'
			);
		}
		// register contextmenu for the tt_news category manager
		$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
			'name' => 'tx_ttnewscatmanager_cm1',
			'path' => t3lib_extMgm::extPath($_EXTKEY).'cm1/class.tx_ttnewscatmanager_cm1.php'
		);
	}
		// Adds a tt_news wizard icon to the content element wizard.
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_ttnews_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi/class.tx_ttnews_wizicon.php';
		// add folder icon
	$ICON_TYPES['news'] = array('icon' => t3lib_extMgm::extRelPath($_EXTKEY).'res/gfx/ext_icon_ttnews_folder.gif');

}

	// register HTML template for the tt_news BackEnd Module
$GLOBALS['TBE_STYLES']['htmlTemplates']['mod_ttnews_admin.html'] = t3lib_extMgm::extRelPath('tt_news').'mod1/mod_ttnews_admin.html';





###########################
## EXTENSION: gg_home_news
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_home_news/ext_tables.php
###########################

$_EXTKEY = 'gg_home_news';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_home_news/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_stadium_gallery
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_stadium_gallery/ext_tables.php
###########################

$_EXTKEY = 'gg_stadium_gallery';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggstadiumgallery_pictures'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_stadium_gallery/locallang_db.xml:tx_ggstadiumgallery_pictures',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'name',	
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggstadiumgallery_pictures.gif',
	),
);

###########################
## EXTENSION: gg_home_stadium
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_home_stadium/ext_tables.php
###########################

$_EXTKEY = 'gg_home_stadium';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_home_stadium/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_fun_stuff
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_fun_stuff/ext_tables.php
###########################

$_EXTKEY = 'gg_fun_stuff';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fun_stuff/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fun_stuff/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_ggfunstuff_funstuff'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_fun_stuff/locallang_db.xml:tx_ggfunstuff_funstuff',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggfunstuff_funstuff.gif',
	),
);

###########################
## EXTENSION: gg_home_cheerleaders
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_home_cheerleaders/ext_tables.php
###########################

$_EXTKEY = 'gg_home_cheerleaders';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_home_cheerleaders/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_cheerleaders
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_cheerleaders/ext_tables.php
###########################

$_EXTKEY = 'gg_cheerleaders';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_ggcheerleaders_gallery'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_cheerleaders/locallang_db.xml:tx_ggcheerleaders_gallery',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggcheerleaders_gallery.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_cheerleaders/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_cheerleaders/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_cheerleaders/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_cheerleaders/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_about_gallery
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_about_gallery/ext_tables.php
###########################

$_EXTKEY = 'ts_about_gallery';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_tsaboutgallery_images'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:ts_about_gallery/locallang_db.xml:tx_tsaboutgallery_images',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_tsaboutgallery_images.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_about_gallery/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_twitter
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_twitter/ext_tables.php
###########################

$_EXTKEY = 'ts_twitter';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_twitter/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_the_score
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_the_score/ext_tables.php
###########################

$_EXTKEY = 'ts_the_score';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_the_score/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_the_score/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_the_score/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_the_score/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_panels
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_panels/ext_tables.php
###########################

$_EXTKEY = 'ts_panels';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi4']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi4',
	$_EXTKEY . '_pi4',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi5']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi5',
	$_EXTKEY . '_pi5',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi6']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_panels/locallang_db.xml:tt_content.list_type_pi6',
	$_EXTKEY . '_pi6',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_meet_the_team
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_meet_the_team/ext_tables.php
###########################

$_EXTKEY = 'ts_meet_the_team';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_meet_the_team/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_skills
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_skills/ext_tables.php
###########################

$_EXTKEY = 'ts_skills';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_skills/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_home_videos
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_home_videos/ext_tables.php
###########################

$_EXTKEY = 'ts_home_videos';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_home_videos/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

$TCA['tx_tshomevideos_videos'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:ts_home_videos/locallang_db.xml:tx_tshomevideos_videos',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_tshomevideos_videos.gif',
	),
);

###########################
## EXTENSION: ts_stadium_gallery
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_stadium_gallery/ext_tables.php
###########################

$_EXTKEY = 'ts_stadium_gallery';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_stadium_gallery/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_stadium_webcam
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_stadium_webcam/ext_tables.php
###########################

$_EXTKEY = 'ts_stadium_webcam';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_stadium_webcam/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_gully_walk
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_gully_walk/ext_tables.php
###########################

$_EXTKEY = 'gg_gully_walk';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_gggullywalk_gw');


t3lib_extMgm::addToInsertRecords('tx_gggullywalk_gw');

$TCA['tx_gggullywalk_gw'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_gully_walk/locallang_db.xml:tx_gggullywalk_gw',		
		'label'     => 'speech_bubble',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_gggullywalk_gw.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_gully_walk/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_wall
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_wall/ext_tables.php
###########################

$_EXTKEY = 'ts_wall';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_wall/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_wall/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_extMgm::allowTableOnStandardPages('tx_tswall_posts');


t3lib_extMgm::addToInsertRecords('tx_tswall_posts');

$TCA['tx_tswall_posts'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:ts_wall/locallang_db.xml:tx_tswall_posts',		
		'label'     => 'message',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_tswall_posts.gif',
	),
);

###########################
## EXTENSION: gg_game
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_game/ext_tables.php
###########################

$_EXTKEY = 'gg_game';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_gggame_scores'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_game/locallang_db.xml:tx_gggame_scores',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_gggame_scores.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_game/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_grub
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_grub/ext_tables.php
###########################

$_EXTKEY = 'gg_grub';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_gggrub_grub'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_grub/locallang_db.xml:tx_gggrub_grub',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_gggrub_grub.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_grub/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_login_logout
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_login_logout/ext_tables.php
###########################

$_EXTKEY = 'gg_login_logout';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_login_logout/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_login_logout/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_offer_panels
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_offer_panels/ext_tables.php
###########################

$_EXTKEY = 'gg_offer_panels';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_offer_panels/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_fanzone_photos
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_fanzone_photos/ext_tables.php
###########################

$_EXTKEY = 'gg_fanzone_photos';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_ggfanzonephotos_photos'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tx_ggfanzonephotos_photos',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggfanzonephotos_photos.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi3']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fanzone_photos/locallang_db.xml:tt_content.list_type_pi3',
	$_EXTKEY . '_pi3',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_fanzone_messages
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_fanzone_messages/ext_tables.php
###########################

$_EXTKEY = 'gg_fanzone_messages';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_ggfanzonemessages_messages');


t3lib_extMgm::addToInsertRecords('tx_ggfanzonemessages_messages');

$TCA['tx_ggfanzonemessages_messages'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tx_ggfanzonemessages_messages',		
		'label'     => 'message',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggfanzonemessages_messages.gif',
	),
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_fanzone_messages/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: fileupload
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/fileupload/ext_tables.php
###########################

$_EXTKEY = 'fileupload';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

t3lib_div::loadTCA("tt_content");
$TCA["tt_content"]["types"]["list"]["subtypes_excludelist"][$_EXTKEY."_pi1"]="layout,select_key";


t3lib_extMgm::addPlugin(Array("LLL:EXT:fileupload/locallang_db.php:tt_content.list_type", $_EXTKEY."_pi1"),"list_type");

###########################
## EXTENSION: ts_blog
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_blog/ext_tables.php
###########################

$_EXTKEY = 'ts_blog';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_blog/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_login_logout
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_login_logout/ext_tables.php
###########################

$_EXTKEY = 'ts_login_logout';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_login_logout/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: ts_ad_panels
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/ts_ad_panels/ext_tables.php
###########################

$_EXTKEY = 'ts_ad_panels';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:ts_ad_panels/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: phpmyadmin
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/phpmyadmin/ext_tables.php
###########################

$_EXTKEY = 'phpmyadmin';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


/**
 * TYPO3 Extension configuration for the tx_phpmyadmin Extension
 *
 * @author		mehrwert <typo3@mehrwert.de>
 * @package		TYPO3
 * @subpackage	tx_phpmyadmin
 * @license		GPL
 * @version		$Id: ext_tables.php 37055 2010-08-20 13:35:20Z mehrwert $
 */

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// If the backend is loaded, add the module
if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModule('tools', 'txphpmyadmin', '', t3lib_extMgm::extPath($_EXTKEY) . 'modsub/');
}

// Require the utilities class and define logoff method for hook
@require_once(t3lib_extMgm::extPath('phpmyadmin').'res/class.tx_phpmyadmin_utilities.php');

// Do not load post processing class if TYPO3 is in CLI mode
if (!defined('TYPO3_cliMode') || !TYPO3_cliMode) {
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_post_processing'][] = 'tx_phpmyadmin_utilities->pmaLogOff';
}

// The subdirectory where the pMA source is located (used for cookie removal and script inclusion)
$TYPO3_CONF_VARS['EXTCONF']['phpmyadmin']['pmaDirname'] = 'phpMyAdmin-3.3.5.1-all-languages';


###########################
## EXTENSION: gg_travel_home
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_travel_home/ext_tables.php
###########################

$_EXTKEY = 'gg_travel_home';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_travel_home/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_events_home
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_events_home/ext_tables.php
###########################

$_EXTKEY = 'gg_events_home';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_events_home/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_edit_details
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_edit_details/ext_tables.php
###########################

$_EXTKEY = 'gg_edit_details';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_edit_details/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

###########################
## EXTENSION: gg_newsletters
## FILE:      /var/www/vhosts/bhafc/www/typo3conf/ext/gg_newsletters/ext_tables.php
###########################

$_EXTKEY = 'gg_newsletters';
$_EXTCONF = $TYPO3_CONF_VARS['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$TCA['tx_ggnewsletters'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:gg_newsletters/locallang_db.xml:tx_ggnewsletters',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ggnewsletters.gif',
	),
);

$tempColumns = array (
	
);


t3lib_div::loadTCA('be_groups');
t3lib_extMgm::addTCAcolumns('be_groups',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('be_groups','');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:gg_newsletters/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');
?>
