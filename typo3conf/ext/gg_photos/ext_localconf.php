<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_ggphotos_pi1.php', '_pi1', 'list_type', 0);
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['pi_ajax'] = 'EXT:gg_photos/class.tx_ggphotos_piajax.php:&tx_ggphotos_piajax->ajaxIdMethods';
$TYPO3_CONF_VARS['EXTCONF']['realurl']['decodeSpURL_preProc']['piajax'] = 'EXT:gg_photos/class.tx_ggphotos_piajax.php:&tx_ggphotos_piajax->ajaxFromRealUrl';
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkDataSubmission']['piajax'] = 'EXT:gg_photos/class.tx_ggphotos_piajax.php:&tx_ggphotos_piajax';
$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/class.db_list_extra.inc']=t3lib_extMgm::extPath('gg_photos').'/lib/class.ux_localRecordList.php';
$TYPO3_CONF_VARS['EXTCONF']['gg_photos']['be_listingclass']['gg_photos'] = 'EXT:gg_photos/lib/class.user_txggphotos_listing.php:&user_txggphotos_listing->user_doHiddenClass';

?>
