<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_ggmessageboard_pi1.php', '_pi1', 'list_type', 0);
if(file_exists(t3lib_extMgm::extPath('gg_message_board').'/lib'))
	$TYPO3_CONF_VARS['EXTCONF']['gg_photos']['be_listingclass']['gg_message_board'] = 'EXT:gg_message_board/lib/class.user_txggmessageboard_listing.php:&user_txggmessageboard_listing->user_markReported';
?>
