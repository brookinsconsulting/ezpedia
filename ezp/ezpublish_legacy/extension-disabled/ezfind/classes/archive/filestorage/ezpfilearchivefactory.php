<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @author pb
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 2.4.0
 * @package ezfind
 *
 */

class ezpFileArchiveFactory
{

    /**
     *
     * @param string $method
     * @param string $path
     */
    public static function getFileArchiveHandler( $method = 'filesystem' )
    {
        switch ( $method ) {
            case 'filesystem':
                return new ezpFileArchiveFileSystem();
                //break;
            default:
                return FALSE;
                //break;
        }
    }




}


?>
