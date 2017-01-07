<?php
/**
 * File containing the Location Search Handler interface
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\SPI\Persistence\Content\Location\Search;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;

/**
 * The Location Search Handler interface defines search operations on Location elements in the storage engine.
 */
interface Handler
{
    /**
     * Finds locations for the given $query
     *
     * @param \eZ\Publish\API\Repository\Values\Content\LocationQuery $query
     */
    public function findLocations( LocationQuery $query );
}
