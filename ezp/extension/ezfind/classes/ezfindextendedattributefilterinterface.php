<?php
/**
 * Extended attribute filter interface
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @author bchoquet
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 5.1.0-rc1
 * @package ezfind
 */
interface eZFindExtendedAttributeFilterInterface
{
    /**
     * Modifies SolR query params according to filter parameters
     * The returned array is merged with global SolR query
     * @param array $queryParams
     * @param array $filterParams
     * @return array $queryParams
     */
    public function filterQueryParams( array $queryParams, array $filterParams );

}
