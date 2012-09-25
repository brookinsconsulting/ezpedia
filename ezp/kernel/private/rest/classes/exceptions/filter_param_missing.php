<?php
/**
 * File containing the ezpRestFilterMissingParameterException exception
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

class ezpRestFilterMissingParameterException extends ezpRestException
{
    public function __construct()
    {
        parent::__construct( "Missing parameter for filter constructor." );
    }
}
