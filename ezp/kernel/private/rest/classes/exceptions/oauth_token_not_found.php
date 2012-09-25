<?php
/**
 * File containing the ezpOauthTokenNotFoundException class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

/**
 * This is the base exception for the eZ Publish oauth library.
 *
 * @package oauth
 */
class ezpOauthTokenNotFoundException extends ezpOauthException
{
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
