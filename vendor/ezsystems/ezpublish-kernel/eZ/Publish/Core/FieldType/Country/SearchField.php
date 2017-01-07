<?php
/**
 * File containing the Country SearchField class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\Core\FieldType\Country;

use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\FieldType\Indexable;
use eZ\Publish\SPI\Persistence\Content\Search;

/**
 * Indexable definition for Country field type
 */
class SearchField implements Indexable
{
    /**
     * Get index data for field for search backend
     *
     * @param Field $field
     *
     * @return \eZ\Publish\SPI\Persistence\Content\Search\Field[]
     */
    public function getIndexData( Field $field )
    {
        return array(
            new Search\Field(
                'value',
                $field->value->data,
                new Search\FieldType\MultipleStringField()
            ),
        );
    }

    /**
     * Get index field types for search backend
     *
     * @return \eZ\Publish\SPI\Persistence\Content\Search\FieldType[]
     */
    public function getIndexDefinition()
    {
        return array(
            'value' => new Search\FieldType\MultipleStringField(),
        );
    }
}
