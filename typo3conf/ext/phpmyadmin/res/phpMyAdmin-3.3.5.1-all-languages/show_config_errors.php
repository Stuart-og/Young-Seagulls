<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Simple wrapper just to enable error reporting and include config
 *
 * @version $Id: show_config_errors.php 37055 2010-08-20 13:35:20Z mehrwert $
 * @package phpMyAdmin
 */

echo "Starting to parse config file...\n";

error_reporting(E_ALL);
/**
 * Read config file.
 */
require './config.inc.php';

?>
