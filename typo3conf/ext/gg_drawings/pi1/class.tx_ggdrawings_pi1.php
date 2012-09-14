<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010  <>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(t3lib_extMgm::extPath('gg_photos').'/pi1/class.tx_ggphotos_pi1.php');


/**
 * Plugin 'GG Drawings' for the 'gg_drawings' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggdrawings
 */
class tx_ggdrawings_pi1 extends tx_ggphotos_pi1 {
	var $prefixId      = 'tx_ggdrawings_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ggdrawings_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_drawings';	// The extension key.
	function main($content,$conf){
		$GLOBALS['TSFE']->additionalHeaderData['jquery.gallerific'] = '<script type="text/javascript" src="fileadmin/templates/js/jquery.galleriffic.js"></script> ';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.opacity'] = '<script type="text/javascript" src="fileadmin/templates/js/jquery.opacityrollover.js"></script> ';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.history'] = '<script type="text/javascript" src="fileadmin/templates/js/jquery.history.js"></script> ';
		$GLOBALS['TSFE']->additionalHeaderData['jquery.thescore'] = '<script type="text/javascript" src="fileadmin/templates/js/thescore.js"></script> ';
		$GLOBALS['TSFE']->additionalHeaderData['css.gallerifiy'] = '<link rel="stylesheet" type="text/css" href="fileadmin/templates/css/fanzone.css" /> ';
		$GLOBALS['TSFE']->additionalHeaderData['css.gallerifiy'] = '<link rel="stylesheet" type="text/css" href="fileadmin/templates/css/side-panels.css" /> ';
		return parent::main($content,$conf);
	}
	function getStoragePid(){
		return $this->findPageByTitle('GG Drawings');
	}
	function getImageType(){
		return 1;
	}
	function generateThumb($original,$thumb){
		$this->shrinkImage($original,$thumb,65,49,'crop');
	}
	
	function getType(){
		return "Drawing";
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_drawings/pi1/class.tx_ggdrawings_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_drawings/pi1/class.tx_ggdrawings_pi1.php']);
}

?>
