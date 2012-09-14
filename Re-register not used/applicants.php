<?php

if($_COOKIE['auth'] != yes){
	die(header('Location: pleaselogin.php'));
	}


$db = new mysqli("localhost", "root", "", "re-register");
	if (!$db){
	die("Could not connect to mysql");
	}
	
	
if($_POST){		
	foreach($_POST as $key => $value){
		$put = $db->query("UPDATE applicants SET added  = '$value' WHERE id = '$key' "); 
		}
	}
	
$records = $db->query("SELECT * FROM applicants ORDER BY id DESC ");
?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>


<div id="applicants-info">
<form id="applicants-page-form" action="applicants.php" method="post">
<?php
	
	while ($applicant = $records->fetch_assoc()){
	
		?>
		
		<div class="applicant-info">
		
			<div class='applicant-name'>
			Name: <?php echo ($applicant['FirstName']." ".$applicant['LastName']);?>
			</div>
			
			<div class='applicant-email'>
			Email: <?php echo ($applicant['email']." ");?>
			</div>
			
			
			<div class='applicant-favplayer'>
			Favourite player: <?php echo ($applicant['Favorite_player']." ");?>
			</div>
		
			<div class='applicant-address'>
			Address:<br />
			<?php echo ($applicant['HouseNumber']." ");?>
			<?php echo ($applicant['addr1']."<br /> ");?>
			<?php if($applicant['addr2'] != ""){echo ($applicant['addr2']."<br /> ");}?>
			<?php if($applicant['addr3'] != ""){echo ($applicant['addr3']."<br />");}?>
			<?php echo ($applicant['City']."<br /> ");?>
			<?php echo ($applicant['County']."<br /> ");?>
			<?php echo ($applicant['Postcode']);?>
			</div>
			
			<div class="added">


			<?php if($applicant['added'] == "true" ){
				?>
				
				<span class="added-label">added:</span>
				
				<input id="<?php echo ($applicant['id']."true"); ?>" type="radio" name="<?php echo ($applicant['id']); ?>" value="true" checked /> 
				<label for="<?php echo ($applicant['id']."true"); ?>">Yes</label>
				
				<input id="<?php echo ($applicant['id']."false"); ?>" type="radio" name="<?php echo ($applicant['id']); ?>" value="false" /> 
				<label for="<?php echo ($applicant['id']."false"); ?>">No</label>
				<?php }
					else{ ?>
					
					<span class="added-label">added:</span>
										
					<input id="<?php echo ($applicant['id']."true"); ?>" type="radio" name="<?php echo ($applicant['id']); ?>" value="true" /> 
					<label for="<?php echo ($applicant['id']."true"); ?>">Yes</label>
					
					<input id="<?php echo ($applicant['id']."false"); ?>" type="radio" name="<?php echo ($applicant['id']); ?>" value="false" checked /> 
					<label for="<?php echo ($applicant['id']."false"); ?>">No</label>

					
					<?php } ?>
			
			</div>
			
		</div>
		
	<?php } ?>
	
	<input type="submit" value="Save" id="save" />
	
</form>	
</div>

</body>