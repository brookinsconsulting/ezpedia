<?php
/**
 * File containing timeout controller
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */
// This will time out


while ( true )
{
    $variable = 'text' + 42;
}

$tpl = eZTemplate::factory();

$Result = array();
$Result['content'] = $tpl->fetch( 'design:test/timeout.tpl' );
return $Result;

?>
