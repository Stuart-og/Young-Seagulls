<?php

require_once('typo3env.php');

$uid = $_GET['uid'];

$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggskills_videos WHERE uid = '.$uid);

if (mysql_num_rows($res) > 0) {
	$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
	$title = $row['title'];
	$desc = $row['description'];
	$file = $row['file'];
	$skill = $row['skill_level'];
}

/*
echo '
<h2>'.$title.'</h2>
<div class="skills-info">
  <p class="intro">'.$desc.'</p>
</div>

<div class="skills-big-img">
  <p style="display: none;">.</p>
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
	flashvars="sourceFLV=http://www.youngseagulls.co.uk/uploads/tx_ggskills/'.$file.'" 
	allowFullScreen="false" 
	allowScriptAccess="sameDomain" 
	salign="" 
	type="application/x-shockwave-flash" >
  </embed>
</div>';
*/

echo '
  <div id="gg-skills-video-info">
	  <h2 class="'.$skill.'star">Start</h2>
	  <h3>'.$title.'</h3>
	  <p>'.$desc.'</p>
  </div>

  <div id="gg-skills-video">
	<div class="skills-big-img">
	  <p style="display: none;">.</p>
	  <embed 
		width="480" 
		height="360" 
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
		flashvars="sourceFLV=/uploads/tx_ggskills/'.$file.'" 
		allowFullScreen="false" 
		allowScriptAccess="sameDomain" 
		salign="" 
		type="application/x-shockwave-flash" >
	  </embed>
	</div>
  </div>';

?>