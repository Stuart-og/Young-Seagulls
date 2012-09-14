<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

if($live=true){
	define('SUPPLYNET_DOMAIN','www.seagulls.talent-sport.co.uk');
} else {
	define('SUPPLYNET_DOMAIN','test.seagulls.talent-sport.co.uk');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_seregistration_pi1.php', '_pi1', 'list_type', 0);


t3lib_extMgm::addPItoST43($_EXTKEY, 'pi2/class.tx_seregistration_pi2.php', '_pi2', 'list_type', 0);
?>
