<?php

$TYPO3_CONF_VARS['SYS']['sitename'] = 'New TYPO3 site';

$TYPO3_CONF_VARS['SYS']['cookieDomain'] = '.youngseagulls.co.uk';

	// Default password is "joh316" :
$TYPO3_CONF_VARS['BE']['installToolPassword'] = 'eric';

$TYPO3_CONF_VARS['EXT']['extList'] = 'version,tsconfig_help,context_help,extra_page_cm_options,impexp,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,css_styled_content,t3skin,t3editor,reports';

$typo_db_extTableDef_script = 'extTables.php';

## INSTALL SCRIPT EDIT POINT TOKEN - all lines after this points may be changed by the install script!

$typo_db_username = 'root';	//  Modified or inserted by TYPO3 Install Tool.
$typo_db_host = 'localhost';	//  Modified or inserted by TYPO3 Install Tool.
$typo_db_pass = $typo_db_password = '';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['encryptionKey'] = 'cddeac77a34e4db300170ef48e641eb8c7634345995f3558b4d4cde551e21448c5764c1abf9220df53595d1ace17de5a';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['compat_version'] = '4.3';	//  Modified or inserted by TYPO3 Install Tool.
$typo_db = 'bhafc2';	// Modified or inserted by TYPO3 Install Tool. 
// Updated by TYPO3 Install Tool 07-12-09 13:12:32
$TYPO3_CONF_VARS['EXT']['extList'] = 'css_styled_content,version,tsconfig_help,context_help,extra_page_cm_options,impexp,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,t3skin,t3editor,reports,simulatestatic,realurl,kickstarter,bhafc_browser_titles,static_info_tables,templavoila,api_macmade,tslib_patcher,loginbox_macmade,se_registration,gg_about_gully,gg_panels,gg_twitter,gg_meet_the_team,gg_drawings,gg_message_board,gg_photos,gg_the_score,gg_skills,tt_news,gg_home_news,gg_stadium_gallery,gg_home_stadium,gg_fun_stuff,gg_home_cheerleaders,gg_cheerleaders,ts_about_gallery,ts_twitter,ts_the_score,ts_panels,ts_meet_the_team,ts_skills,ts_home_videos,ts_stadium_gallery,ts_stadium_webcam,gg_gully_walk,ts_wall,gg_game,gg_grub,gg_login_logout,gg_offer_panels,gg_fanzone_photos,gg_fanzone_messages,fileupload,ts_blog,ts_login_logout,ts_ad_panels,phpmyadmin,gg_travel_home,gg_events_home,gg_edit_details,gg_newsletters';	// Modified or inserted by TYPO3 Extension Manager. 
$TYPO3_CONF_VARS['EXT']['extList_FE'] = 'css_styled_content,install,rtehtmlarea,t3skin,simulatestatic,realurl,kickstarter,bhafc_browser_titles,static_info_tables,templavoila,api_macmade,tslib_patcher,loginbox_macmade,se_registration,gg_about_gully,gg_panels,gg_twitter,gg_meet_the_team,gg_drawings,gg_message_board,gg_photos,gg_the_score,gg_skills,tt_news,gg_home_news,gg_stadium_gallery,gg_home_stadium,gg_fun_stuff,gg_home_cheerleaders,gg_cheerleaders,ts_about_gallery,ts_twitter,ts_the_score,ts_panels,ts_meet_the_team,ts_skills,ts_home_videos,ts_stadium_gallery,ts_stadium_webcam,gg_gully_walk,ts_wall,gg_game,gg_grub,gg_login_logout,gg_offer_panels,gg_fanzone_photos,gg_fanzone_messages,fileupload,ts_blog,ts_login_logout,ts_ad_panels,phpmyadmin,gg_travel_home,gg_events_home,gg_edit_details,gg_newsletters';	// Modified or inserted by TYPO3 Extension Manager. 
$TYPO3_CONF_VARS['EXT']['extConf']['realurl'] = 'a:5:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"1";s:14:"autoConfFormat";s:1:"0";s:12:"enableDevLog";s:1:"0";s:19:"enableChashUrlDebug";s:1:"0";}';	// Modified or inserted by TYPO3 Extension Manager. 
$TYPO3_CONF_VARS['EXT']['extConf']['templavoila'] = 'a:1:{s:7:"enable.";a:1:{s:13:"oldPageModule";s:1:"1";}}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['tt_news'] = 'a:20:{s:13:"useStoragePid";s:1:"1";s:17:"requireCategories";s:1:"0";s:18:"useInternalCaching";s:1:"1";s:11:"cachingMode";s:6:"normal";s:13:"cacheLifetime";s:1:"0";s:13:"cachingEngine";s:8:"internal";s:11:"treeOrderBy";s:3:"uid";s:13:"prependAtCopy";s:1:"1";s:5:"label";s:5:"title";s:9:"label_alt";s:0:"";s:10:"label_alt2";s:0:"";s:15:"label_alt_force";s:1:"0";s:21:"categorySelectedWidth";s:1:"0";s:17:"categoryTreeWidth";s:1:"0";s:25:"l10n_mode_prefixLangTitle";s:1:"1";s:22:"l10n_mode_imageExclude";s:1:"1";s:20:"hideNewLocalizations";s:1:"0";s:24:"writeCachingInfoToDevlog";s:10:"disabled|0";s:23:"writeParseTimesToDevlog";s:1:"0";s:18:"parsetimeThreshold";s:3:"0.1";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 12-01-10 13:48:07
$TYPO3_CONF_VARS['SYS']['sitename'] = 'BHAFC';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['BE']['disable_exec_function'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['gdlib_png'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_combine_filename'] = '';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_path'] = '';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_path_lzw'] = '';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 20-01-10 10:58:24
// Updated by TYPO3 Extension Manager 26-01-10 13:58:31


if(file_exists($file = dirname(__FILE__).'/../../config/config.php')) {
	require_once($file);
	$typo_db_username = __MYSQL_USER__;	//  Modified or inserted by TYPO3 Install Tool.
	$typo_db_host = __MYSQL_HOST__;	//  Modified or inserted by TYPO3 Install Tool.
	$typo_db_pass = $typo_db_password = __MYSQL_PASS__;	//  Modified or inserted by TYPO3 Install Tool.
	$typo_db = __MYSQL_NAME__;	// Modified or inserted by TYPO3 Install Tool. 
}

$TYPO3_CONF_VARS['BE']['installToolPassword'] = '582777ee253eb0a2c9816846a4a355d3';	// Modified or inserted by TYPO3 Install Tool.

// Updated by TYPO3 Extension Manager 10-05-10 18:41:37
$TYPO3_CONF_VARS['BE']['maxFileSize'] = '9999999';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 15-07-10 15:06:48
// Updated by TYPO3 Extension Manager 22-09-10 23:34:40
$TYPO3_CONF_VARS['SYS']['setDBinit'] = 'SET CHARACTER SET utf8;'.chr(10).'SET NAMES utf8;'.chr(10).'SET SESSION character_set_server=utf8;';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 23-09-10 11:08:05
// Updated by TYPO3 Extension Manager 28-09-10 19:55:51
$TYPO3_CONF_VARS["FE"]["realurl"]["enabled"] = '1';
$TYPO3_CONF_VARS["FE"]["realurl"]["expireDays"] = 60; // Value is in days
$TYPO3_CONF_VARS["FE"]["realurl"]["debug"] = 0; // Set this to 0 (zero) on production-servers!
$TYPO3_CONF_VARS["FE"]["realurl"]["langCodes"] = array(0 => ''); // Leave empty to disable a language-prefix in the URL
$TYPO3_CONF_VARS["FE"]["realurl"]["langDescs"] = array(0 => '');
$TYPO3_CONF_VARS["FE"]["realurl"]["typeToPage"] = array(0 => 'index', 98 => 'printer');
$TYPO3_CONF_VARS["FE"]["realurl"]["fileNameToType"] = array('' => 0, 'index.html' => 0, 'printer.html' => 98);

$TYPO3_CONF_VARS['EXTCONF']['realurl'] = array (
        '_DEFAULT' => array(
            'init' => array(
                		'useCHashCache' => 0,
                		'enableCHashCache' => 0,
                		'enableUrlDecodeCache' => 0,
                		'enableUrlEncodeHash' => 0,
                		'appendMissingSlash' => 'ifNotFile',
                		'noMatch' => 'bypass'
                	),
                	'redirects' => array(
    			),
        		'preVars' => array(
        			array(
        				'GETvar' => 'no_cache',
        				'valueMap' => array(
        					'nc' => 1,
        					),
        				'noMatch' => 'bypass',
    				),
    			),
                'fileName' => array(
                        'defaultToHTMLsuffixOnPrev' => 0,
                        'page/html' => array(
                                'keyValues' => array(
                                        'type' => 1
                                )
                        ),
                        '_DEFAULT' => array(
                                'keyValues' => array(

                                )
                        )
                ),

                'pagePath' => array(
                        'type' => 'user',
                        'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
                        'spaceCharacter' => '-',
                        'languageGetVar' => 'L',
                        'expireDays' => '0',
                        'disablePathCache' => 1,
                        'rootpage_id' => 2

                )
        )
);

$TYPO3_CONF_VARS['EXT']['extConf']['phpmyadmin'] = 'a:2:{s:12:"hideOtherDBs";s:1:"1";s:9:"uploadDir";s:21:"uploads/tx_phpmyadmin";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 05-12-10 21:59:59
// Updated by TYPO3 Install Tool 04-11-11 09:02:50
// Updated by TYPO3 Extension Manager 09-07-12 10:46:01
?>