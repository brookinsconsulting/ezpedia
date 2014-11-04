<?php
/**
 * ezcCacheStorageFileOptionsTest 
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
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */


/**
 * Abstract base test class for ezcCacheStorageFileOptions tests.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileOptionsTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageFileOptionsTest" );
	}
    
    public function testConstructor()
    {
        $fake = new ezcCacheStorageFileOptions(
            array( 
                'ttl'          => 86400,
                'extension'    => '.cache',
                'permissions'  => 0644, 
                'lockFile'     => '.ezcLock',
                'lockWaitTime' => 200000,
                'maxLockTime'  => 5,
                'metaDataFile' => '.ezcMetaData',
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcCacheStorageFileOptions(),
            'Default values incorrect for ezcCacheStorageFileOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcCacheStorageFileOptions();

        $this->assertEquals( $opt['ttl'], 86400 );
        $this->assertEquals( $opt['extension'], '.cache' );
        $this->assertEquals( $opt['permissions'], 0644 );
        $this->assertEquals( $opt['lockFile'], '.ezcLock' );
        $this->assertEquals( $opt['lockWaitTime'], 200000 );
        $this->assertEquals( $opt['maxLockTime'], 5 );
        $this->assertEquals( $opt['metaDataFile'], '.ezcMetaData' );
    }

    public function testGetAccessSuccess()
    {
        $opt = new ezcCacheStorageFileOptions();

        $this->assertEquals( $opt->ttl, 86400 );
        $this->assertEquals( $opt->extension, ".cache" );
        $this->assertEquals( $opt->permissions, 0644 );
        $this->assertEquals( $opt->lockFile, '.ezcLock' );
        $this->assertEquals( $opt->metaDataFile, '.ezcMetaData' );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcCacheStorageFileOptions();
        
        try
        {
            echo $opt->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on access to invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcCacheStorageFileOptions();

        $this->assertSetProperty(
            $opt,
            'ttl',
            array( 0, 23, false )
        );

        $this->assertSetProperty(
            $opt,
            'permissions',
            array( 0, 0777 )
        );

        $this->assertSetProperty(
            $opt,
            'extension',
            array( '.foo' )
        );

        $this->assertSetProperty(
            $opt,
            'lockFile',
            array( '.foo' )
        );

        $this->assertSetProperty(
            $opt,
            'lockWaitTime',
            array( 100000 )
        );

        $this->assertSetProperty(
            $opt,
            'maxLockTime',
            array( 10 )
        );

        $this->assertSetProperty(
            $opt,
            'metaDataFile',
            array( '.foo' )
        );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcCacheStorageFileOptions();

        $this->assertSetPropertyFails(
            $opt,
            'ttl',
            array( true, 23.42, 'foo', array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'permissions',
            array( true, 23.42, 'foo', array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'extension',
            array( true, false, 23.42, array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'lockFile',
            array( true, false, 23.42, array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'lockWaitTime',
            array( true, false, 23.42, array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'maxLockTime',
            array( true, false, 23.42, array(), new stdClass() )
        );

        $this->assertSetPropertyFails(
            $opt,
            'metaDataFile',
            array( true, false, 23.42, array(), new stdClass() )
        );

        try
        {
            $opt->foo = "bar";
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on set access to invalid property." );
    }

    public function testIssetAccess()
    {
        $opt = new ezcCacheStorageFileOptions();
        
        $this->assertTrue( isset( $opt->ttl ) );
        $this->assertTrue( isset( $opt->extension ) );
        $this->assertTrue( isset( $opt->permissions ) );
        $this->assertTrue( isset( $opt->lockFile ) );
        $this->assertTrue( isset( $opt->lockWaitTime ) );
        $this->assertTrue( isset( $opt->maxLockTime ) );
        $this->assertTrue( isset( $opt->metaDataFile ) );

        $this->assertFalse( isset( $opt->foo ) );
    }

    public function testMergeOptions()
    {
        $options = new ezcCacheStorageFileOptions();
        $optionsNew = new ezcCacheStorageOptions();
        $optionsNew->ttl = 30;
        $options->mergeStorageOptions( $optionsNew );
        $this->assertEquals( 30, $options->ttl );
    }

    public function testOptions()
    {
        $obj = new ezcCacheStorageFileArray( $this->createTempDir( __CLASS__ ) );
        $options = new ezcCacheStorageFileOptions();
        $optionsGeneral = new ezcCacheStorageOptions();
        
        $this->assertEquals( $options, $obj->getOptions() );

        $obj->options = $optionsGeneral;
        $this->assertEquals( $options, $obj->getOptions() );

        $obj->options = $options;
        $this->assertEquals( $options, $obj->getOptions() );

        $obj->setOptions( $optionsGeneral );
        $this->assertEquals( $options, $obj->getOptions() );

        $obj->setOptions( $options );
        $this->assertEquals( $options, $obj->getOptions() );

        try
        {
            $obj->setOptions( 'wrong value' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals(
                "The value 'wrong value' that you were trying to assign to "
                    . "setting 'options' is invalid. Allowed values are: " 
                    . "instance of ezcCacheStorageFileOptions or (deprecated) "
                    . "ezcCacheStorageOptions.",
                $e->getMessage()
            );
        }
    }

    public function testProperties()
    {
        $obj = new ezcCacheStorageFileArray( $this->createTempDir( __CLASS__ ) );
        $options = new ezcCacheStorageFileOptions();

        $this->assertTrue(
            isset( $obj->options )
        );

        $obj->options = $options;
        $this->assertSame(
            $options,
            $obj->options
        );

        $this->assertSetPropertyFails(
            $obj,
            'options',
            array( true, false, 23, 42.23, 'foo', new stdClass() )
        );
    }

    protected function genericSetFailureTest( $obj, $property, $value )
    {
        try
        {
            $obj->$property = $value;
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "ezcBaseValueException not thrown on invalid value '$value' for " . get_class( $obj ) . "->$property." );
    }
}
?>
