<?php
/**
 * File containing the ezpRestException class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2013.4
 * @package kernel
 */

/**
 * This is the base exception for the eZ Publish REST layer
 *
 * @package rest
 */
abstract class ezpRestException extends ezcBaseException
{
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
