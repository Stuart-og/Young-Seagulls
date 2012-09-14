<form method="post" action="<?=$_SERVER['php_self']?>" id="gg-reg-form">
<?
	if($errors) { 
?>
	<div class='error'>There has been a problem with registration, please correct the marked fields below</div>
<?
	}
?>
			<!--  First name -->
<?
	function pad2($string){
		return str_pad($string,2,'0',STR_PAD_LEFT);
	}
	if(!$fields)
		include(dirname(__FILE__).'/../fields.php');
	foreach($fields as $name=>$config){
		$colour = (++$count%2)?"blue":"white";
		$post = $config['required'] ? "*" : "";
		$validation = array();
		if($config['required']) $validation[] = 'required';
		if($config['email']) $validation[] = 'custom[email]';
		$class = $validation ? "validate[".join("|",$validation)."]" : "";
		$value = $values[$name];
?>
	<div class="gg-form-row <?=$colour?>">
<?
		if($e = $errors[$name]){
?>
	<div class='error'><?=$e?></div>
<?
		}
?>
	<p class="left"><?=$config['name'].$post?>:</p>
<?
		switch($config['type']){
		case 'date':
			if(preg_match("/(.{4})(.{2})(.{2})/",$value,$matches)){
				array_shift($matches);
			}
			$periods = array_combine(array("year","month","day"),$matches);
			$years = array_merge(array(0),range(1993,date("Y")));
			$years = array_combine($years,$years);
			$years[0]="Year";

			$parts = array(
				'day'=>array_map('pad2',array_merge(array("Day"),range(1,31))),
				'month'=>array_map('pad2',array_merge(array("Month"),array("January","February","March","April","May","June","July","August","September","October","November","December"))),

				'year'=>$years
			);
			foreach($parts as $period=>$options){
				$value = $periods[$period];
?>
	<select name="<?=$name?>-<?=$period?>" class="gg-select left <?=$class?>">
<?				foreach($options as $k=>$v){
	if($k) $k=str_pad($k,2,'0',STR_PAD_LEFT);
	if($k=='0') $k='';
	$selected = ($k==$value)?" selected='true'":"";
?>
	<option value='<?=$k?>'<?=$selected?>><?=$v?></option>
<?  } ?>
</select>
<?
			}
			break;
		case 'radio':
		case 'checkboxes':
			$type = $config['type'];
			$iname = $name;
			if($type=='checkboxes'){
				$type='checkbox';
				$iname.="[]";
			}
?>
<div class="left">
<? 
	foreach($config['options'] as $k=>$v) {
	$selected = false;
	switch($type){
	case 'checkbox':
		if(array_search($k,$value)!==false){
			$selected = true;
		}
		break;
	default:
		if($k==$value) $selected = $true;
	}
	$selected = $selected ? " checked='checked'":""
?>
	<div class="gg-reg-radio-check"><input type="<?=$type?>" id='<?=$name?>-<?=$k?>' name="<?=$iname?>" value="<?=$k?>" class="gg-radio-button <?=$class?>"<?=$selected?>/> <label for='<?=$name?>-<?=$k?>'><?=$v?></label></div>
	<? } ?>
</div>
<?
			break;
		case 'checkbox':
?>
	<input type="checkbox" name="<?=$name?>" value="1" class="gg-checkbox left <?=$class?>" />
<?
			break;
		case 'multi':
			foreach($config['fields'] as $field){
				$myval = $value[$field];
?>
	<input type="text" name="gg-reg-<?=$field?>" class="gg-reg-text-input-small left <?=$myval?"":"click-clear"?> <?=$class?>" value="<?=$myval ? $myval : ucfirst($field)?>" />
<?
			}
			break;
		case 'password':
?>
	<input type="password" name="<?=$name?>" class="gg-reg-text-input left <?=$class?>" value='<?=$value?>'/>
<?
			break;
		default:
?>
	<input type="text" name="<?=$name?>" class="gg-reg-text-input left <?=$class?>" value='<?=$value?>'/>
<?
		}
?>
	<div class="clearer"></div>
		</div>
<?
	}

?>
			<!--  Submit -->
<div class="gg-form-row">
<input type="hidden" name="gg-form-sent" value="1" />
<input type="submit" value="Send" class="right" name='submit' />
</div>

</form>
