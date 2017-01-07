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
 * Tests the ezcPersistentObjecColumns class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectColumnsTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectColumnsTest' );
    }

    public function testConstructureSuccess()
    {
        $columns = new ezcPersistentObjectColumns();
        $this->assertEquals(
            0,
            count( $columns )
        );
    }

    public function testArrayAccessSuccess()
    {
        $columns = new ezcPersistentObjectColumns();
        $property = new ezcPersistentObjectProperty();
        $columns['foo'] = $property;

        $this->assertEquals(
            1,
            count( $columns )
        );
        $this->assertSame(
            $property,
            $columns['foo']
        );
        
        $idProperty = new ezcPersistentObjectIdProperty();
        $columns['bar'] = $idProperty;

        $this->assertEquals(
            2,
            count( $columns )
        );
        $this->assertSame(
            $idProperty,
            $columns['bar']
        );
    }

    public function testArrayAccessFailure()
    {
        $columns = new ezcPersistentObjectColumns();

        $this->genericArrayAccessFailure(
            $columns,
            'foo',
            array(
                23, 23.42, true, "test", array(), new stdClass(),
            ),
            'ezcBaseValueException'
        );
        $this->genericArrayAccessFailure(
            $columns,
            23,
            array(
                new ezcPersistentObjectProperty(),
            ),
            'ezcBaseValueException'
        );
    }

    public function testExchangeArraySuccess()
    {
        $columns = new ezcPersistentObjectColumns();
        $columns['foo'] = new ezcPersistentObjectProperty();
        
        $this->assertEquals(
            1,
            count( $columns )
        );

        $columns->exchangeArray( array() );
        $this->assertEquals(
            0,
            count( $columns )
        );

        $columns->exchangeArray(
            array(
                'foo' => new ezcPersistentObjectProperty(),
                'bar' => new ezcPersistentObjectProperty(),
            )
        );
        $this->assertEquals(
            2,
            count( $columns )
        );
    }

    public function testExchangeArrayFailure()
    {
        $columns = new ezcPersistentObjectColumns();
        $columns['foo'] = new ezcPersistentObjectProperty();
        
        $this->assertEquals(
            1,
            count( $columns )
        );

        try
        {
            $columns->exchangeArray(
                array( 'foo' => 23 )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $columns->exchangeArray(
                array( 23 => new ezcPersistentObjectProperty )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid offset in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testSetFlagsSuccess()
    {
        $columns = new ezcPersistentObjectColumns();
        $columns->setFlags( 0 );
        $this->assertEquals(
            0,
            $columns->getFlags()
        );
    }

    public function testSetFlagsFailure()
    {
        $columns = new ezcPersistentObjectColumns();

        try
        {
            $columns->setFlags( 23 );
            $this->fail( 'ezcBaseValueException not thrown on flags different to 0.' );
        }
        catch ( ezcBaseValueException $e ) {}
        $this->assertEquals(
            0,
            $columns->getFlags()
        );
    }

    public function testAppendFailure()
    {
        $columns = new ezcPersistentObjectColumns();

        try
        {
            $columns[] = new ezcPersistentObjectProperty();
            $this->fail( 'ezcBaseValueException not thrown on trying to append.' );
        }
        catch ( Exception $e ) {}
        $this->assertEquals(
            0,
            count( $columns )
        );
    }

    protected function genericArrayAccessFailure( ArrayAccess $columns, $offset, array $values, $exceptionClass )
    {
        foreach ( $values as $value )
        {
            try
            {
                $columns[$offset] = $value;
                $this->fail( $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $columns ) . '.' );
            }
            catch ( Exception $e )
            {
                $this->assertEquals(
                    $exceptionClass,
                    get_class( $e ),
                    $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $columns ) . ', ' . get_class( $e ) . ' thrown instead.'
                );
            }
        }
    }

}


?>
