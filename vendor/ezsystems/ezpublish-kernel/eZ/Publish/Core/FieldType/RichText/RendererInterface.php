<?php
/**
 * File containing the RichText Renderer interface
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\Core\FieldType\RichText;

/**
 * RichText field type renderer interface, to be implemented in MVC layer.
 */
interface RendererInterface
{
    /**
     * Renders template tag
     *
     * @param string $name
     * @param array $parameters
     * @param boolean $isInline
     *
     * @return string
     */
    public function renderTag( $name, array $parameters, $isInline );

    /**
     * Renders Content embed
     *
     * @param int|string $contentId
     * @param string $viewType
     * @param array $parameters
     * @param boolean $isInline
     *
     * @return string
     */
    public function renderContentEmbed( $contentId, $viewType, array $parameters, $isInline );

    /**
     * Renders Location embed
     *
     * @param int|string $locationId
     * @param string $viewType
     * @param array $parameters
     * @param boolean $isInline
     *
     * @return string
     */
    public function renderLocationEmbed( $locationId, $viewType, array $parameters, $isInline );
}
