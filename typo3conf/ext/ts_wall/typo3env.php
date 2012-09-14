<?php
//require_once(dirname(__FILE__).'/../../ev_content_api/test/init.php');
//require_once(PATH_site.'/../share/Library/lib/header.php');
	define('TYPO3_PROCEED_IF_NO_USER',1);
	if(defined('TYPO3_MODE')) return;
	define ('PATH_site',realpath(dirname(__FILE__).'/../../../').'/');
	$_SERVER['DOCUMENT_ROOT'] = PATH_site;
	ini_set('include_path',ini_get('include_path').':'.PATH_site.'/..');
	//ini_set('error_reporting',E_ALL&(~E_WARNING)&(~E_NOTICE));

	$bt = debug_backtrace();
	$bt = $bt[count($bt)-1];
	$file = $bt['file'];
	unset($bt);
	$mod_path = '..'.strstr(dirname($file),"/typo3conf").'/';
	define('TYPO3_MOD_PATH',$mod_path);
//	array_shift($_SERVER['argv']);
//	$_SERVER['argc']--;

	$_SERVER['SCRIPT_FILENAME']=$file;
//	require_once(dirname(__FILE__).'/../../../../../config/local.config.php');
//	$_SERVER['HTTP_HOST'] = $GLOBALS['SRV_URL'];
//	$_SERVER['REMOTE_ADDR'] = $GLOBALS['SRV_IP'];

	require_once(dirname(__FILE__).'/../../../typo3/init.php');
	chdir(PATH_site.'/..');
	//require_once 'share/logger/lib/logger.php';
	//ini_get('display_errors');
	

	initTYPO3Config();
	initTYPO3LangObject();
	makePage($_GET['id']);
	function initTYPO3LangObject() {
		static $done=false;
		if($done) return;
		$done = true;
		require_once(PATH_typo3.'sysext/lang/lang.php');
		global $LANG;
		$LANG = t3lib_div::makeInstance('language');
		global $BE_USER;
		$LANG->init($BE_USER->uc['lang']);
	}
	
	/**
	 * \brief	Init typo3 config
	 */
	function initTYPO3Config() {
		#logger('initializing TYPO3 config', logger::DETAIL);
		static $configDone = false;
		if($configDone===true) {
			return;
		} else {
			$configDone = true;
		}//die('next: ws is not pass the second time');
		global $TT;
		global $TYPO3_LOADED_EXT;
		
		chdir(PATH_site);

		require_once(PATH_t3lib.'class.t3lib_timetrack.php');
		//require_once dirname(__FILE__).'/class.ux_t3lib_timeTrack.php';
		$TT = new t3lib_timeTrack;
		$TT->start();
		$TT->push('','Script start');

		if (!defined('PATH_tslib')) {
			define('PATH_tslib', t3lib_extMgm::extPath('cms').'tslib/');
		}


		///// [DF] 404 handling -- we should prevent 404s ever happening***
		global $TYPO3_CONF_VARS;
		$TYPO3_CONF_VARS['FE']['pageNotFound_handling'] = null;
		///



		require_once(PATH_t3lib.'class.t3lib_db.php');
		$TYPO3_DB = t3lib_div::makeInstance('t3lib_DB');
		$TYPO3_DB->debugOutput = $TYPO3_CONF_VARS['SYS']['sqlDebug'];

		//$CLIENT = t3lib_div::clientInfo();				// Set to the browser: net / msie if 4+ browsers
		$TT->pull();


		// *******************************
		// Checking environment
		// *******************************
		if (t3lib_div::int_from_ver(phpversion())<4001000)	die ('TYPO3 runs with PHP4.1.0+ only');

		if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS']))	die('You cannot set the GLOBALS-array from outside the script.');
		if (!get_magic_quotes_gpc())	{
			$TT->push('Add slashes to GET/POST arrays','');
			t3lib_div::addSlashesOnArray($_GET);
			t3lib_div::addSlashesOnArray($_POST);
		//	$_GET['ADMCMD_previewWS'] = 123;
			$HTTP_GET_VARS = $_GET; 	// TODO: Override this -- should be passed in the function arguments
			$HTTP_POST_VARS = $_POST; 	// TODO: Override this -- should be passed in the function arguments
			$TT->pull();
		}
/*
		if($workspace!==null) {
			$_GET['ADMCMD_previewWS'] = $workspace;
		}*/
	//	print_r($_GET); die('!!!'.t3lib_div::GPVar('ADMCMD_previewWS').'!!!');

		// *********************
		// Look for extension ID which will launch alternative output engine
		// *********************
		if ($temp_extId = t3lib_div::_GP('eID'))	{
			if ($classPath = t3lib_div::getFileAbsFileName($TYPO3_CONF_VARS['FE']['eID_include'][$temp_extId]))	{
				require_once(PATH_tslib.'class.tslib_eidtools.php');
				require($classPath);
			}
			exit;
		}

		// *********************
		// Libraries included
		// *********************
		$TT->push('Include Frontend libraries','');
			require_once(PATH_tslib.'class.tslib_fe.php');
			require_once(PATH_t3lib.'class.t3lib_page.php');
			require_once(PATH_t3lib.'class.t3lib_userauth.php');
			require_once(PATH_tslib.'class.tslib_feuserauth.php');
			require_once(PATH_t3lib.'class.t3lib_tstemplate.php');
			require_once(PATH_t3lib.'class.t3lib_cs.php');
		$TT->pull();

		//require_once dirname(__FILE__).'/class.ux_tslib_fe.php';
		//require_once dirname(__FILE__).'/class.ux_tslib_feUserAuth.php';
	}
	
	/**
	 * \brief	Builds the HTML page
	 */
	 function makePage($pageUid) {
		#logger('Creating page: '.$pageUid, logger::DETAIL);

		global $TT,
			$TYPO3_CONF_VARS,
			$TSFE;

		// ***********************************
		// Create $TSFE object (TSFE = TypoScript Front End)
		// Connecting to database
		// ***********************************
		$temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
		$TSFE = new $temp_TSFEclassName(
				$TYPO3_CONF_VARS,
				$pageUid,//t3lib_div::_GP('id'), // Pass these in function arguments
				t3lib_div::_GP('type'),
				t3lib_div::_GP('no_cache'),
				t3lib_div::_GP('cHash'),
				t3lib_div::_GP('jumpurl'),
				t3lib_div::_GP('MP'),
				t3lib_div::_GP('RDCT')
			);
		
		require_once PATH_tslib.'/class.tslib_content.php';
		$TSFE->cObj = t3lib_div::makeInstance('tslib_cObj');
		
		$TSFE->connectToDB();

			// In case of a keyword-authenticated preview, re-initialize the TSFE object:
		if ($temp_previewConfig = $TSFE->ADMCMD_preview())	{
			$TSFE = new $temp_TSFEclassName(
				$TYPO3_CONF_VARS,
				t3lib_div::_GP('id'),
				t3lib_div::_GP('type'),
				t3lib_div::_GP('no_cache'),
				t3lib_div::_GP('cHash'),
				t3lib_div::_GP('jumpurl'),
				t3lib_div::_GP('MP'),
				t3lib_div::_GP('RDCT')
			);
			$TSFE->ADMCMD_preview_postInit($temp_previewConfig);
		}

		if ($TSFE->RDCT)	{$TSFE->sendRedirect();}



		t3lib_extMgm::typo3_loadExtensions();

		// *******************
		// output compression
		// *******************
		if ($TYPO3_CONF_VARS['FE']['compressionLevel'])	{
			ob_start();
			require_once(PATH_t3lib.'class.gzip_encode.php');
		}

		// *********
		// FE_USER
		// *********
		$TT->push('Front End user initialized','');
			$TSFE->initFEuser();
		//print_r(get_class($TSFE->fe_user));die();
		$TT->pull();

		// ****************
		// PRE BE_USER HOOK
		// ****************
		if (is_array($TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preBeUser'])) {
			foreach($TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preBeUser'] as $_funcRef) {
				$_params = array();
				t3lib_div::callUserFunction($_funcRef, $_params , $_params);
			}
		}
		
		// TODO: Put this in a config file somewhere ***
		$TSFE->ADMCMD_preview_BEUSER_uid = 4;
		
		// *********
		// BE_USER
		// *********
		global $GLOBALS;
		
		$BE_USER='';
		$GLOBALS['BE_USER'] = & $BE_USER;
		if ($_COOKIE['be_typo_user']) {		// If the backend cookie is set, we proceed and checks if a backend user is logged in.
			$TYPO3_MISC['microtime_BE_USER_start'] = microtime();
			$TT->push('Back End user initialized','');
				require_once (PATH_t3lib.'class.t3lib_befunc.php');
				require_once (PATH_t3lib.'class.t3lib_userauthgroup.php');
				require_once (PATH_t3lib.'class.t3lib_beuserauth.php');
				require_once (PATH_t3lib.'class.t3lib_tsfebeuserauth.php');

					// the value this->formfield_status is set to empty in order to disable login-attempts to the backend account through this script
				$BE_USER = t3lib_div::makeInstance('t3lib_tsfeBeUserAuth');	// New backend user object
				$BE_USER->OS = TYPO3_OS;
				$BE_USER->lockIP = $TYPO3_CONF_VARS['BE']['lockIP'];
				$BE_USER->start();			// Object is initialized
				$BE_USER->unpack_uc('');
				if ($BE_USER->user['uid'])	{
					$BE_USER->fetchGroupData();
					$TSFE->beUserLogin = 1;
				}
				/*
				if ($BE_USER->checkLockToIP() && $BE_USER->checkBackendAccessSettingsFromInitPhp())	{
					$BE_USER->extInitFeAdmin();
					if ($BE_USER->extAdmEnabled)	{
						require_once(t3lib_extMgm::extPath('lang').'lang.php');
						$LANG = t3lib_div::makeInstance('language');
						$LANG->init($BE_USER->uc['lang']);

						$BE_USER->extSaveFeAdminConfig();
							// Setting some values based on the admin panel
						$TSFE->forceTemplateParsing = $BE_USER->extGetFeAdminValue('tsdebug', 'forceTemplateParsing');
						$TSFE->displayEditIcons = $BE_USER->extGetFeAdminValue('edit', 'displayIcons');
						$TSFE->displayFieldEditIcons = $BE_USER->extGetFeAdminValue('edit', 'displayFieldIcons');

						if (t3lib_div::_GP('ADMCMD_editIcons'))	{
							$TSFE->displayFieldEditIcons=1;
							$BE_USER->uc['TSFE_adminConfig']['edit_editNoPopup']=1;
						}
						if (t3lib_div::_GP('ADMCMD_simUser'))	{
							$BE_USER->uc['TSFE_adminConfig']['preview_simulateUserGroup']=intval(t3lib_div::_GP('ADMCMD_simUser'));
							$BE_USER->ext_forcePreview=1;
						}
						if (t3lib_div::_GP('ADMCMD_simTime'))	{
							$BE_USER->uc['TSFE_adminConfig']['preview_simulateDate']=intval(t3lib_div::_GP('ADMCMD_simTime'));
							$BE_USER->ext_forcePreview=1;
						}

							// Include classes for editing IF editing module in Admin Panel is open
						if (($BE_USER->extAdmModuleEnabled('edit') && $BE_USER->extIsAdmMenuOpen('edit')) || $TSFE->displayEditIcons == 1)	{
							$TSFE->includeTCA();
							if ($BE_USER->extIsEditAction())	{
								require_once (PATH_t3lib.'class.t3lib_tcemain.php');
								$BE_USER->extEditAction();
							}
							if ($BE_USER->extIsFormShown())	{
								require_once(PATH_t3lib.'class.t3lib_tceforms.php');
								require_once(PATH_t3lib.'class.t3lib_iconworks.php');
								require_once(PATH_t3lib.'class.t3lib_loaddbgroup.php');
								require_once(PATH_t3lib.'class.t3lib_transferdata.php');
							}
						}

						if ($TSFE->forceTemplateParsing || $TSFE->displayEditIcons || $TSFE->displayFieldEditIcons)	{ $TSFE->set_no_cache(); }
					}

			//		$WEBMOUNTS = (string)($BE_USER->groupData['webmounts'])!='' ? explode(',',$BE_USER->groupData['webmounts']) : Array();
			//		$FILEMOUNTS = $BE_USER->groupData['filemounts'];
				} else {	// Unset the user initialization.
					$BE_USER='';
					$TSFE->beUserLogin=0;
				}
				*/
			$TT->pull();
			$TYPO3_MISC['microtime_BE_USER_end'] = microtime();
		} elseif ($TSFE->ADMCMD_preview_BEUSER_uid)	{
			require_once (PATH_t3lib.'class.t3lib_befunc.php');
			require_once (PATH_t3lib.'class.t3lib_userauthgroup.php');
			require_once (PATH_t3lib.'class.t3lib_beuserauth.php');
			require_once (PATH_t3lib.'class.t3lib_tsfebeuserauth.php');

				// the value this->formfield_status is set to empty in order to disable login-attempts to the backend account through this script
			$BE_USER = t3lib_div::makeInstance('t3lib_tsfeBeUserAuth');	// New backend user object
			$BE_USER->userTS_dontGetCached = 1;
			$BE_USER->OS = TYPO3_OS;
			$BE_USER->setBeUserByUid($TSFE->ADMCMD_preview_BEUSER_uid);
			$BE_USER->unpack_uc('');
			
			if ($BE_USER->user['uid'])	{
				$BE_USER->fetchGroupData();
				$TSFE->beUserLogin = 1;
			} else {
				$BE_USER = '';
				$TSFE->beUserLogin = 0;
			}
			
			$TSFE->includeTCA();
			if($BE_USER != null)
				$BE_USER->extInitFeAdmin(); // this load config for previewing hidden item on frontend -- 
			// TODO: Should this be configurable ?? -- so we don't output hidden items to the LIVE workspace??
		}
		
		// ********************
		// Workspace preview:
		// ********************
		$TSFE->workspacePreviewInit();
		
		
		// *****************************************
		// Proces the ID, type and other parameters
		// After this point we have an array, $page in TSFE, which is the page-record of the current page, $id
		// *****************************************
		$TT->push('Process ID','');
//			$TSFE->checkAlternativeIdMethods(); -- [DF, 14/Feb] I have removed this because realurls has a hard time. there is probably a much better fix
			$TSFE->clear_preview();
			$TSFE->determineId();

				// Now, if there is a backend user logged in and he has NO access to this page, then re-evaluate the id shown!
			if ($TSFE->beUserLogin && (!$BE_USER->extPageReadAccess($TSFE->page) || t3lib_div::_GP('ADMCMD_noBeUser')))	{	// t3lib_div::_GP('ADMCMD_noBeUser') is placed here because workspacePreviewInit() might need to know if a backend user is logged in!

					// Remove user
				unset($BE_USER);
				$TSFE->beUserLogin = 0;

					// Re-evaluate the page-id.
				$TSFE->checkAlternativeIdMethods();
				$TSFE->clear_preview();
				$TSFE->determineId();
			}
			$TSFE->makeCacheHash();
		$TT->pull();


		// *******************************************
		// Get compressed $TCA-Array();
		// After this, we should now have a valid $TCA, though minimized
		// *******************************************
		// $TSFE->getCompressedTCarray(); *** [DF, 27 jan. I have removed this, but not sure of the implications. Bug was: TCA[pages][columns] was *always* empty after this point.]
//debug($GLOBALS['TCA']['pages'],'<<'); t3lib_div::loadTCA('pages'); debug(array_keys($GLOBALS['TCA']['pages']['columns'])); die();
		// ********************************
		// Starts the template
		// *******************************
		$TT->push('Start Template','');
			$TSFE->initTemplate();
		$TT->pull();
		

		// ********************************
		// Get from cache
		// *******************************
		//$TT->push('Get Page from cache','');
		//	$TSFE->getFromCache();
		//$TT->pull();


		// ******************************************************
		// Get config if not already gotten
		// After this, we should have a valid config-array ready
		// ******************************************************
		$TSFE->getConfigArray();


		// ********************************
		// Convert POST data to internal "renderCharset" if different from the metaCharset:
		// *******************************
		$TSFE->convPOSTCharset();


		// *******************************************
		// Setting the internal var, sys_language_uid + locale settings
		// *******************************************
		$TSFE->settingLanguage();
		$TSFE->settingLocale();


		// ********************************
		// Check JumpUrl
		// *******************************
		$TSFE->setExternalJumpUrl();
		$TSFE->checkJumpUrlReferer();


		// ********************************
		// Check Submission of data.
		// This is done at this point, because we need the config values
		// *******************************
		/*switch($TSFE->checkDataSubmission())	{
			case 'email':
				require_once(PATH_t3lib.'class.t3lib_htmlmail.php');
				require_once(PATH_t3lib.'class.t3lib_formmail.php');
				$TSFE->sendFormmail();
			break;
			case 'fe_tce':
				require_once(PATH_tslib.'class.tslib_fetce.php');
				$TSFE->includeTCA();
				$TT->push('fe_tce','');
				$TSFE->fe_tce();
				$TT->pull();
			break;
		}*/


		// ********************************
		// Generate page
		// *******************************
		$TSFE->setUrlIdToken();
		
		
		return;
		
		
		$TT->push('Page generation','');
		//if ($TSFE->doXHTML_cleaning())	{require_once(PATH_t3lib.'class.t3lib_parsehtml.php');}
		if ($TSFE->isGeneratePage())	{
				$TSFE->generatePage_preProcessing();
				$temp_theScript=$TSFE->generatePage_whichScript();

				if ($temp_theScript)	{
					include($temp_theScript);
				} else {
					require_once(PATH_tslib.'class.tslib_pagegen.php');
					include(PATH_tslib.'pagegen.php');
				}
				$TSFE->generatePage_postProcessing();
		} elseif ($TSFE->isINTincScript())	{
			require_once(PATH_tslib.'class.tslib_pagegen.php');
			include(PATH_tslib.'pagegen.php');
		}
		$TT->pull();

		#logger('pre generate');

		// ********************************
		// $GLOBALS['TSFE']->config['INTincScript']
		// *******************************
		if ($TSFE->isINTincScript())		{
			$TT->push('Non-cached objects','');
				$INTiS_config = $GLOBALS['TSFE']->config['INTincScript'];

					// Special feature: Include libraries
				$TT->push('Include libraries');
				foreach($INTiS_config as $INTiS_cPart)	{
					if ($INTiS_cPart['conf']['includeLibs'])	{
						$INTiS_resourceList = t3lib_div::trimExplode(',',$INTiS_cPart['conf']['includeLibs'],1);
						$GLOBALS['TT']->setTSlogMessage('Files for inclusion: "'.implode(', ',$INTiS_resourceList).'"');

						foreach($INTiS_resourceList as $INTiS_theLib)	{
							$INTiS_incFile = $GLOBALS['TSFE']->tmpl->getFileName($INTiS_theLib);
							if ($INTiS_incFile)	{
								require_once('./'.$INTiS_incFile);
							} else {
								$GLOBALS['TT']->setTSlogMessage('Include file "'.$INTiS_theLib.'" did not exist!',2);
							}
						}
					}
				}
				$TT->pull();
				$TSFE->INTincScript();
			$TT->pull();
		}

		// ***************
		// Output content
		// ***************
		if ($TSFE->isOutputting())	{
			$TT->push('Print Content','');
			$TSFE->processOutput();

			// ***************************************
			// Outputs content / Includes EXT scripts
			// ***************************************
			if ($TSFE->isEXTincScript())	{
				$TT->push('External PHP-script','');
						// Important global variables here are $EXTiS_*, they must not be overridden in include-scripts!!!
					$EXTiS_config = $GLOBALS['TSFE']->config['EXTincScript'];
					$EXTiS_splitC = explode('<!--EXT_SCRIPT.',$GLOBALS['TSFE']->content);			// Splits content with the key.

						// Special feature: Include libraries
					reset($EXTiS_config);
					while(list(,$EXTiS_cPart)=each($EXTiS_config))	{
						if ($EXTiS_cPart['conf']['includeLibs'])	{
							$EXTiS_resourceList = t3lib_div::trimExplode(',',$EXTiS_cPart['conf']['includeLibs'],1);
							$GLOBALS['TT']->setTSlogMessage('Files for inclusion: "'.implode(', ',$EXTiS_resourceList).'"');
							reset($EXTiS_resourceList);
							while(list(,$EXTiS_theLib)=each($EXTiS_resourceList))	{
								$EXTiS_incFile=$GLOBALS['TSFE']->tmpl->getFileName($EXTiS_theLib);
								if ($EXTiS_incFile)	{
									require_once($EXTiS_incFile);
								} else {
									$GLOBALS['TT']->setTSlogMessage('Include file "'.$EXTiS_theLib.'" did not exist!',2);
								}
							}
						}
					}

					reset($EXTiS_splitC);
					while(list($EXTiS_c,$EXTiS_cPart)=each($EXTiS_splitC))	{
						if (substr($EXTiS_cPart,32,3)=='-->')	{	// If the split had a comment-end after 32 characters it's probably a split-string
							$EXTiS_key = 'EXT_SCRIPT.'.substr($EXTiS_cPart,0,32);
							if (is_array($EXTiS_config[$EXTiS_key]))	{
								$REC = $EXTiS_config[$EXTiS_key]['data'];
								$CONF = $EXTiS_config[$EXTiS_key]['conf'];
								$content='';
								include($EXTiS_config[$EXTiS_key]['file']);
								echo $content;	// The script MAY return content in $content or the script may just output the result directly!
							}
							echo substr($EXTiS_cPart,35);
						} else {
							echo ($c?'<!--EXT_SCRIPT.':'').$EXTiS_cPart;
						}
					}

				$TT->pull();
			} else {
				$content = $GLOBALS['TSFE']->content;
			}
			$TT->pull();
		}
		#logger('Rendered content with strlen='.strlen($content), logger::DETAIL);
		return $content;

		// ********************************
		// Store session data for fe_users
		// ********************************
		// Not needed: $TSFE->storeSessionData();


		// ***********
		// Statistics
		// ***********
		/*
		not needed
		$TYPO3_MISC['microtime_end'] = microtime();
		$TSFE->setParseTime();
		if ($TSFE->isOutputting() && ($TSFE->TYPO3_CONF_VARS['FE']['debug'] || $TSFE->config['config']['debug']))	{
			echo '
		<!-- Parsetime: '.$TSFE->scriptParseTime.' ms-->';
		}*/
		//Not needed: $TSFE->statistics();


		// ***************
		// Check JumpUrl
		// ***************
		//not needed $TSFE->jumpurl();


		// *************
		// Preview info
		// *************
		//Not needed $TSFE->previewInfo();


		// ******************
		// Publishing static
		// ******************
		if (is_object($BE_USER))	{
			if ($BE_USER->extAdmModuleEnabled('publish') && $BE_USER->extPublishList)	{
				include_once(PATH_tslib.'publish.php');
			}
		}


		// ******************
		// Hook for end-of-frontend
		// ******************
		$TSFE->hook_eofe();


		// ********************
		// Finish timetracking
		// ********************
		$TT->pull();



		// *************
		// Admin panel
		// *************
		/*
		if (is_object($BE_USER)
			&& $GLOBALS['TSFE']->beUserLogin
			&& $GLOBALS['TSFE']->config['config']['admPanel']
			&& $BE_USER->extAdmEnabled
		//	&& $BE_USER->extPageReadAccess($GLOBALS['TSFE']->page)	// This is already done, if there is a BE_USER object at this point!
			&& !$BE_USER->extAdminConfig['hide'])	{
				echo $BE_USER->extPrintFeAdminDialog();
		}*/


		// *************
		// Debugging Output
		// *************
		/*if(@is_callable(array($error,'debugOutput'))) {
			$error->debugOutput();
		}*/
		//if (TYPO3_DLOG)	t3lib_div::devLog('END of FRONTEND session','',0,array('_FLUSH'=>TRUE));


		// *************
		// Compressions
		// *************
		/*if ($TYPO3_CONF_VARS['FE']['compressionLevel'])	{
			new gzip_encode($TYPO3_CONF_VARS['FE']['compressionLevel'], false, $GLOBALS['TYPO3_CONF_VARS']['FE']['compressionDebugInfo']);
		}*/
	}

?>
