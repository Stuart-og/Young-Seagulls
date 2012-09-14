<?php

$vid = $_GET['vid'];

echo '<p style="display: none;">.</p>
<embed 
	width="370" 
	height="240" 
	src="typo3conf/ext/ts_skills/swf/video.swf" 
	quality="high" 
	pluginspage="http://www.macromedia.com/go/getflashplayer" 
	align="middle" 
	play="true" 
	loop="true" 
	scale="showall" 
	wmode="transparent" 
	devicefont="false" 
	bgcolor="#000000" 
	name="video" 
	menu="true" 
	flashvars="sourceFLV=/uploads/tx_tshomevideos/'.$vid.'" 
	allowFullScreen="false" 
	allowScriptAccess="sameDomain" 
	salign="" 
	type="application/x-shockwave-flash" >
</embed>';

?>