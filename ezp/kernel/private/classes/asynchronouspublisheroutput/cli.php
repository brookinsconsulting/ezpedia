<?php
/**
 * File containing the ezpAsynchronousPublisherCliOutput class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version  4.2011
 * @package kernel
 */

/**
 * Handles asynchronous publishing output to CLI
 * @package kernel
 */
class ezpAsynchronousPublisherCliOutput implements ezpAsynchronousPublisherOutput
{
    public function __construct()
    {
        $this->cli = eZCLI::instance();
    }

    public function write( $message )
    {
        $this->cli->output( $message );
    }

    private $cli;
}
?>
