<?
	class user_txggphotos_listing{
		function user_doHiddenClass($params){
			extract($params);
			return $row['hidden'] ? "db_list_hidden" : "db_list_normal";
		}
	}
