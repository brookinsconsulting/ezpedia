<?php
/**
 * File containing the ezpContentCriteriaInterface interface.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version  4.2011
 * @package API
 */

/**
 * This interface is the base one when it comes to implementing content query criteria
 * @package API
 */
interface ezpContentCriteriaInterface
{
    /**
     * Return the criteria as a value usable by eZContentObjectTreeNode
     * Temporary method that needs to be refactored
     *
     * @return array
     */
    public function translate();
}
?>
