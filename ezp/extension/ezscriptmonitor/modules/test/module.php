<?php
/**
 * File containing module definition
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */

$Module = array( 'name' => 'Test',
                 'variable_params' => true );

$ViewList = array();

$ViewList['timeout'] = array(
    'script' => 'timeout.php',
    );

$ViewList['antitimeout'] = array(
    'script' => 'antitimeout.php',
    );

?>
