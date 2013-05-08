<?php
/**
 * File containing ezpRestApiViewController
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */


class ezpRestApiViewController implements ezpRestViewControllerInterface
{
    /**
     * Creates a view required by controller's result
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult $result
     * @return ezcMvcView
     */
    public function loadView( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
        if ( $routeInfo->controllerClass === 'ezpRestAtomController' )
        {
            return new ezpRestAtomView( $request, $result );
        }
        return new ezpRestJsonView( $request, $result );
    }

}
