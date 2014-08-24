<?php
/**
 * File containing the MetadataHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */
namespace eZ\Publish\Core\IO;

interface MetadataHandler
{
    /**
     * Extracts metadata for the file identified by $path
     * @param string $path
     *
     * @return array Metadata hash
     */
    public function extract( $path );
}
