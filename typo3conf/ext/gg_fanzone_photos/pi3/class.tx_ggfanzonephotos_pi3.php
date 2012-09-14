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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'GG Fanzone Photo Upload' for the 'gg_fanzone_photos' extension.
 *
 * @author	 <>
 * @package	TYPO3
 * @subpackage	tx_ggfanzonephotos
 */
class tx_ggfanzonephotos_pi3 extends tslib_pibase {
	var $prefixId      = 'tx_ggfanzonephotos_pi3';		// Same as class name
	var $scriptRelPath = 'pi3/class.tx_ggfanzonephotos_pi3.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'gg_fanzone_photos';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
$GLOBALS['TSFE']->additionalHeaderData['css.fanzonePhotos'] = '<link rel="stylesheet" href="fileadmin/templates/css/fanzone-photos.css" type="text/css" media="screen" />';

/* UPLOADIFY
 * Upload works but can't write to database
$GLOBALS['TSFE']->additionalHeaderData['css.uploadify'] = '<link rel="stylesheet" href="/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/uploadify.css" type="text/css" media="screen" />';
$GLOBALS['TSFE']->additionalHeaderData['script.swfObject'] = '<script type="text/javascript" src="/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/swfobject.js"></script>';
$GLOBALS['TSFE']->additionalHeaderData['script.uploadify'] = '<script type="text/javascript" src="/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/jquery.uploadify.v2.1.0.min.js"></script>';
$GLOBALS['TSFE']->additionalHeaderData['script.uploadifyHeader'] = '
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		\'uploader\'       : \'/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/uploadify.swf\',
		\'script\'         : \'/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/uploadify.php\',
		\'cancelImg\'      : \'/typo3conf/ext/gg_fanzone_photos/jquery.uploadify/cancel.png\',
		\'folder\'         : \'/uploads/tx_ggfanzonephotos/\',
		\'queueID\'        : \'fileQueue\',
		\'auto\'           : true,
		\'multi\'          : false
	});
});
</script>';

$content .= '
<div id="fileQueue"></div>
<input type="file" name="uploadify" id="uploadify" />
<p><a href="javascript:jQuery(\'#uploadify\').uploadifyClearQueue()">Cancel All Uploads</a></p>';
*/	



/* VALUM */
$GLOBALS['TSFE']->additionalHeaderData['script.valum'] = '<script type="text/javascript" src="/typo3conf/ext/gg_fanzone_photos/valum/client/fileuploader.js"></script>';
$GLOBALS['TSFE']->additionalHeaderData['css.valum'] = '<link rel="stylesheet" href="/typo3conf/ext/gg_fanzone_photos/valum/client/fileuploader.css" type="text/css" media="screen" />';


$content = '
<p><a href="http://github.com/valums/file-uploader">Back to project page</a></p>

<p>To upload a file, click on the button below. Drag-and-drop is supported in FF, Chrome.</p>
<p>Progress-bar is supported in FF3.6+, Chrome6+, Safari4+</p>

<div id="file-uploader-demo1">
	<noscript>
		<p>Please enable JavaScript to use file uploader.</p>
		<!-- or put a simple form for upload here -->
	</noscript>
</div>

<script>

    function createUploader(){
        var uploader = new qq.FileUploader({
            element: document.getElementById(\'file-uploader-demo1\'),
            action: \'http://www.youngseagulls.co.uk/typo3conf/ext/gg_fanzone_photos/upload-photo.php\'
        });
    }
    // in your app create uploader as soon as the DOM is ready
    // dont wait for the window to load
    window.onload = createUploader;
</script>';

		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi3/class.tx_ggfanzonephotos_pi3.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/gg_fanzone_photos/pi3/class.tx_ggfanzonephotos_pi3.php']);
}

?>