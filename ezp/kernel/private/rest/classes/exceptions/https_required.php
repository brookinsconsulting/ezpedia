<?php
/**
 * File containing the ezpRestHTTPSRequiredException exception
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

class ezpRestHTTPSRequiredException extends ezpRestException
{
    public function __construct()
    {
        parent::__construct( "Communication over HTTPS is required." );
    }
}
