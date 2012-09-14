<?php

require_once('../typo3env.php');

$id = $_GET['id'];

$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, 'SELECT * FROM tx_ggmeettheteam_players WHERE uid = '.$id.';');

if (mysql_num_rows($res) > 0) {
	$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
	$name = $row['firstname'] .' '.$row['lastname'];
	$position = $row['position'];
	$nationality = $row['nationality'];
	$nick_name = $row['nickname'];
	$dob = date('d/m/Y', $row['dob']);
	$special = $row['special'];
	$biog = $row['biog'];
	$pics = explode(',',$row['pics']);
	
	#print_r($pics);
	#die();
	
	$slideshow_gallery = '';
	foreach($pics as $k => $v) {
		/*$slideshow_gallery .= '
		<li>
		  <a class="thumb" name="'.$name.'" href="uploads/tx_ggmeettheteam/'.$v.'" title="'.$name.'">
			<img src="uploads/tx_ggmeettheteam/'.$v.'" alt="Title #0" width="65" height="49" />
		  </a>
		</li>';*/
		
		//$vid_thumbs .= '<img src="/typo3conf/thumb.php?src=uploads/tx_ggskills/'.$thumb.'&w=65&h=49&zc=1'" alt="'.$title.'" />';
	
		$slideshow_gallery .= '
		<li>
		  <a class="thumb" name="'.$name.'" href="/typo3conf/thumb.php?src=uploads/tx_ggmeettheteam/'.$v.'&w=364&h=294&zc=1" title="'.$name.'">
			<img src="/typo3conf/thumb.php?src=uploads/tx_ggmeettheteam/'.$v.'&w=65&h=49&zc=1" alt="'.$name.'" />
		  </a>
		</li>';

	}
}

echo '
    <h2>'.$name.'</h2>
	<div id="controls" class="controls"></div>
	<div id="loading" class="loader"></div>
	<div id="slideshow" class="slideshow"></div>

	<div id="thumbs" class="navigation">
		<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
		<ul class="thumbs noscript">
			'.$slideshow_gallery.'
		</ul>
		<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
	</div> <!-- /#thumbs -->
	<!-- End Gallery Html Containers -->

	<div style="position: absolute; top: 420px;">
		<h3>Position: <span class="white">'.$position.'</span></h3>
		<p><strong>Nationality:</strong> <span class="blue">'.$nationality.'</span><br />
		<strong>Nick Name:</strong> <span class="blue">'.$nick_name.'</span><br />
		<strong>Date of Birth:</strong> <span class="blue">'.$dob.'</span><br />
		<strong>Special Skills:</strong> <span class="blue">'.$special.'</span></p>
		<p>'.$biog.'</p>
	  </div>
	</div>';
?>
