<?php

/**
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @author pb
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 5.1.0-rc1
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
