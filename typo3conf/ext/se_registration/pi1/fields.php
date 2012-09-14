<?
	$fields = array(
		"gg-reg-fname"=>
		array(
			"name"=>"First Name",
			"required"=>true
		),
		"gg-reg-lname"=>
		array(
			"name"=>"Last Name",
			"required"=>true
		),
		"gg-reg-dob"=>
		array(
			"name"=>"Date of birth",
			"required"=>true,
			"type"=>"date"
		),
		"gg-reg-gender"=>
		array(
			"name"=>"Gender",
			"type"=>"radio",
			"options"=>array("M"=>"Boy","F"=>"Girl"),
			"required"=>true
		),
		"gg-reg-email"=>
		array(
			"name"=>"Email",
			"required"=>true,
			"email"=>true,
			),
		"gg-reg-add1"=>
		array(
			"name"=>"Address line 1",
			"required"=>true,
		),
		"gg-reg-add2"=>
		array(
			"name"=>"Address line 2",
		),
		"gg-reg-add3"=>
		array(
			"name"=>"Address line 3",
		),
		"gg-reg-town"=>
		array(
			"name"=>"Town",
		),
		"gg-reg-county"=>
		array(
			"name"=>"County",
		),
		"gg-reg-pcode"=>
		array(
			"name"=>"Postcode",
			"required"=>true,
		),
		"gg-reg-home-phone"=>
		array(
			"name"=>"Home phone",
		),
		"gg-reg-daytime-phone"=>
		array(
			"name"=>"Daytime phone",
		),
		"gg-reg-school"=>
		array(
			"name"=>"Your school",
		),
		"gg-reg-parent"=>
		array(
			"name"=>"Name of parent or guardian",
			"required"=>true,
		),
		"gg-reg-team"=>
		array(
			"name"=>"Do you play for either of the following",
			"type"=>"checkboxes",
			"options"=>array(
				"SundayTeam"=>"Seagulls Club FC Sunday Team",
				"SeagullsSpecials"=>"Seagulls Specials"
			)
		),
		"gg-reg-seat"=>
		array(
			"name"=>"Are you a season ticket holder? If so please indicate stand/block/row/seat",
			"type"=>"multi",
			"fields"=>array("stand","block","row","seat"),
		),
		"gg-reg-fav-player"=> array(
			"name"=>"Who is your favourite Albion player?"
		),
		"gg-reg-password"=>array(
			"name"=>"Enter the password you would like to use when logging into Gully's Gang",
			"required"=>true,
			"type"=>"password"
		),
		"gg-reg-additional"=>
		array(
			"name"=>"Tick this box if you don't want to receive other Albion material",
			"type"=>"checkbox",
			"options"=>array('1'=>'')
		),
	);
?>
