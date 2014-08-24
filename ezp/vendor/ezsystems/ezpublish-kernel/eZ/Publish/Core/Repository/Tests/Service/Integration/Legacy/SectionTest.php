<?php
/**
 * File contains: eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy\SectionTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\Core\Repository\Tests\Service\Integration\Legacy;

use eZ\Publish\Core\Repository\Tests\Service\Integration\SectionBase as BaseSectionServiceTest;
use Exception;

/**
 * Test case for Section Service using Legacy storage class
 */
class SectionTest extends BaseSectionServiceTest
{
    protected function getRepository()
    {
        try
        {
            return Utils::getRepository();
        }
        catch ( Exception $e )
        {
            $this->markTestIncomplete(  $e->getMessage() );
        }
    }
}
