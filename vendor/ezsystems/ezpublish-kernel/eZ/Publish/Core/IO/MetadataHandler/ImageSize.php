<?php
/**
 * File containing the ImageSize class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */
namespace eZ\Publish\Core\IO\MetadataHandler;
use eZ\Publish\Core\IO\MetadataHandler;

class ImageSize implements MetadataHandler
{
    public function extract( $filePath )
    {
        $metadata = getimagesize( $filePath );

        return array(
            'width' => $metadata[0],
            'height' => $metadata[1],
            // required until a dedicated mimetype metadata handler is added
            'mime' => $metadata['mime'],
        );

    }
}
