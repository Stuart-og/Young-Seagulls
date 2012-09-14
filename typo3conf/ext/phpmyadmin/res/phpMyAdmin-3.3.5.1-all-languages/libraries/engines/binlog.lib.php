<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @version $Id: binlog.lib.php 37055 2010-08-20 13:35:20Z mehrwert $
 * @package phpMyAdmin-Engines
 */

/**
 *
 * @package phpMyAdmin-Engines
 */
class PMA_StorageEngine_binlog extends PMA_StorageEngine
{
    /**
     * returns string with filename for the MySQL helppage
     * about this storage engne
     *
     * @return  string  mysql helppage filename
     */
    function getMysqlHelpPage()
    {
        return 'binary-log';
    }
}

?>