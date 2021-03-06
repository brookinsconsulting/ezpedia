<?php
/**
 * File containing the LocationViewPass class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler;

/**
 * The LocationViewPass adds DIC compiler pass related to content view.
 * This includes adding ContentViewProvider implementations.
 *
 * @see \eZ\Publish\Core\MVC\Symfony\View\Manager
 * @see \eZ\Publish\Core\MVC\Symfony\View\ContentViewProvider
 */
class LocationViewPass extends ViewPass
{
    const VIEW_PROVIDER_IDENTIFIER = "ezpublish.location_view_provider";
    const ADD_VIEW_PROVIDER_METHOD = "addLocationViewProvider";
}
