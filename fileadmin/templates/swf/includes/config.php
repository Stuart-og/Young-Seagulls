<?php
include '../../../../config/config.php';
// Database Constants

defined('DB_SERVER') ? null : define("DB_SERVER", __MYSQL_HOST__);
defined('DB_USER')   ? null : define("DB_USER", __MYSQL_USER__);
defined('DB_PASS')   ? null : define("DB_PASS", __MYSQL_PASS__);
defined('DB_NAME')   ? null : define("DB_NAME", __MYSQL_NAME__);

//defined('DB_SERVER') ? null : define("DB_SERVER", "rkodigital.nazwa.pl:3307");
//defined('DB_USER')   ? null : define("DB_USER", "rkodigital_40");
//defined('DB_PASS')   ? null : define("DB_PASS", "KOmin123");
//defined('DB_NAME')   ? null : define("DB_NAME", "rkodigital_40");

?>