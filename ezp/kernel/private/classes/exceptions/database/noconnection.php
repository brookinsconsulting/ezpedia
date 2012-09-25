<?php
/**
 * File containing the eZDBNoConnectionException class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version  4.2011
 * @package kernel
 */

/**
 * Class representing a no connection exception
 *
 * @version  4.2011
 * @package kernel
 */

class eZDBNoConnectionException extends eZDBException
{
    /**
     * Constructs a new eZDBNoConnectionException
     *
     * @param string $host The hostname
     * @return void
     */
    function __construct( $host, $errorMessage, $errorNumber )
    {
        parent::__construct( "Unable to connect to the database server '{$host}'\nError #{$errorNumber}: {$errorMessage}" );
    }
}
?>
