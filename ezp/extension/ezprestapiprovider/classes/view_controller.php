<?php
/**
 * File containing ezpRestApiViewController
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
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
