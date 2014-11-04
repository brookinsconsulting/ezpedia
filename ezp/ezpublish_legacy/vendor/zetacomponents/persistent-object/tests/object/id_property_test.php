<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the ezcPersistentObjectIdProperty class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectIdPropertyTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectIdPropertyTest' );
    }

    public function testConstructureSuccess()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertAttributeEquals(
            array(
                'columnName'       => null,
                'resultColumnName' => null,
                'propertyName'     => null,
                'propertyType'     => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'generator'        => null,
                'visibility'       => null,
                'databaseType'     => PDO::PARAM_STR,
            ),
            'properties',
            $property
        );
        
        
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentNativeGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            PDO::PARAM_LOB
        );
        $this->assertAttributeEquals(
            array(
                'columnName'       => 'column',
                'resultColumnName' => 'column',
                'propertyName'     => 'property',
                'propertyType'     => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'generator'        => new ezcPersistentGeneratorDefinition(
                    new ezcPersistentNativeGenerator()
                ),
                'visibility'   => ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                'databaseType' => PDO::PARAM_LOB,
            ),
            'properties',
            $property
        );
    }

    public function testConstructureFailure()
    {
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                23,
                'foo',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $columnName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                23,
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                'baz',
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value of type string for parameter $visibility.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                'foo',
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyType.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                'foo'
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyType.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testGetAccessSuccess()
    {
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            PDO::PARAM_LOB
        );

        $this->assertEquals(
            'column',
            $property->columnName
        );
        $this->assertEquals(
            'column',
            $property->resultColumnName
        );
        $this->assertEquals(
            'property',
            $property->propertyName
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->visibility
        );
        $this->assertEquals(
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            $property->generator
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->propertyType
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );
    }

    public function testGetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            PDO::PARAM_LOB
        );
        try
        {
            echo $property->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on get access to invalid property $foo.' );
    }
    
    public function testSetAccessSuccess()
    {
        $property = new ezcPersistentObjectIdProperty();
        $property->columnName   = 'column';
        $property->propertyName ='property';
        $property->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
        $property->visibility   = ezcPersistentObjectProperty::VISIBILITY_PROTECTED;
        $property->generator    = new ezcPersistentGeneratorDefinition(
            new ezcPersistentManualGenerator()
        );
        $property->databaseType = PDO::PARAM_LOB;

        $this->assertEquals(
            'column',
            $property->columnName
        );
        $this->assertEquals(
            'column',
            $property->resultColumnName
        );
        $this->assertEquals(
            'property',
            $property->propertyName
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->propertyType
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            $property->visibility
        );
        $this->assertEquals(
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            $property->generator
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );

        $property->columnName = 'CamelCase';
        $this->assertEquals(
            'CamelCase',
            $property->columnName
        );
        $this->assertEquals(
            'camelcase',
            $property->resultColumnName
        );
    }
    
    public function testSetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertSetPropertyFails(
            $property,
            'columnName',
            array( true, false, 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'propertyName',
            array( true, false, 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'propertyType',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'visibility',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'generator',
            array( true, false, 'foo', 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'databaseType',
            array( true, false, 'foo', 23, 23.42, array(), new stdClass() )
        );
    }

    public function testIssetAccessSuccess()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertTrue(
            isset( $property->columnName ),
            'Property $columnName seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->propertyName ),
            'Property $propertyName seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->propertyType ),
            'Property $propertyType seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->visibility ),
            'Property $visibility seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->generator ),
            'Property $generator seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->databaseType ),
            'Property $databaseType seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->resultColumnName ),
            'Property $resultColumnName seems not to be set.'
        );
    }

    public function testIssetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertFalse(
            isset( $property->foo ),
            'Property $foo seems to be set.'
        );
    }
}


?>
