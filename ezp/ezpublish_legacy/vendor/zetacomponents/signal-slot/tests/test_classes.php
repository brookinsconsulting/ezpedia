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
 * @package SignalSlot
 * @subpackage Tests
 */

/**
 * Wrapper of normal static connection class. This is because we can't reset it to NULL after it has been set in SignalCollection
 */
class EmptyStaticConnections implements ezcSignalStaticConnectionsBase
{
    public function getConnections( $identifier, $signal )
    {
        return ezcSignalStaticConnections::getInstance()->getConnections( $identifier, $signal );
    }
}


class TheGiver
{
    public $signals;

    public function __construct( $signalID = null )
    {
        if ( $signalID === null )
        {
            $this->signals = new ezcSignalCollection( __CLASS__ );
        }
        else
        {
            $this->signals = new ezcSignalCollection( $signalID );
        }
    }
}


class TheReceiver
{
    public static $globalFunctionRun = false;
    public static $staticFunctionRun = false;
    public $stack = array();

    public function slotNoParams1()
    {
        array_push( $this->stack, "slotNoParams1" );
    }

    public function slotNoParams2()
    {
        array_push( $this->stack, "slotNoParams2" );
    }

    public function slotNoParams3()
    {
        array_push( $this->stack, "slotNoParams3" );
    }

    public function slotNoParams4()
    {
        array_push( $this->stack, "slotNoParams4" );
    }

    public function slotNoParams5()
    {
        array_push( $this->stack, "slotNoParams5" );
    }

    public function slotSingleParam( $param1 )
    {
        array_push( $this->stack, $param1 );
    }

    public function slotDoubleParams( $param1, $param2 )
    {
        array_push( $this->stack, "{$param1}{$param2}" );
    }

    public function slotTrippleParams( $param1, $param2, $param3 )
    {
        array_push( $this->stack, "{$param1}{$param2}{$param3}" );
    }

    public function slotZeroOrMoreParams()
    {
        $params = func_get_args();
        array_push( $this->stack, join( ' ', $params ) );
    }

    public function slotOneOrMoreParams( $param1 )
    {
        $params = func_get_args();
        array_push( $this->stack, join( ' ', $params ) );
    }

    public static function slotStatic()
    {
        self::$staticFunctionRun = "have a cigar";
    }
}

function slotFunction()
{
    TheReceiver::$globalFunctionRun = "brain damage";
}

?>
