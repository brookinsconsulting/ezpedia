<?php
/**
 * File containing php script for cleaning up the expired non-activated subscription
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */

/**
 * clean up the subscription expired
 */
if ( !$isQuiet )
    $cli->output( "Start cleaning up the subscription..."  );
$ezcommentsINI = eZINI::instance( 'ezcomments.ini' );
$expiryDays = $ezcommentsINI->variable( 'NotificationSettings', 'DaysToCleanupSubscription' );
$time = -1;
if ( $expiryDays != '-1' )
{
    $time = 60 * 60 * 24 * (float)$expiryDays;
}
$result = ezcomSubscriptionManager::cleanupExpiredSubscription( $time );

if ( !is_null( $result ) )
{
    if ( !$isQuiet )
        $cli->output( count($result) . " subscription have been cleaned up!"  );
}
else
{
    if ( !$isQuiet )
        $cli->output( "No subscription has been cleaned up!"  ); 
}
?>
