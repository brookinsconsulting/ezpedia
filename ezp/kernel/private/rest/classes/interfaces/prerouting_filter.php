<?php
/**
 * File containing the ezpRestPreRoutingFilterInterface interface
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

interface ezpRestPreRoutingFilterInterface
{
    public function __construct( ezcMvcRequest $request );
    public function filter();
}
