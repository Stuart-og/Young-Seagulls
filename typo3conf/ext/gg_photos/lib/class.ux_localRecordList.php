<?
class ux_localRecordList extends localRecordList {
	function renderListRow($table,$row,$cc,$titleCol,$thumbsCol,$indent=0)	{

		       	//= 'EXT:gg_photos/lib/clsas.ux_localRecordList.php:&ux_localRecordList->doHiddenClass';
		foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['gg_photos']['be_listingclass'] as $hook){
			$hookParams = array(
				"table"=>$table,
				"row"=>$row,
			);
			if($class = t3lib_div::callUserFunction($hook, $hookParams, $this)){
				$classes[] = $class;
			}
		}
		if($classes) $row["_CSSCLASS"] = join(" ",$classes);
		return parent::renderListRow($table,$row,$cc,$titleCol,$thumbsCol,$indent);
	}
}
?>
