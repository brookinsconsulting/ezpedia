<?php
/**
 * File containing the oauthadmin/list view definition
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version  4.2011
 * @package kernel
 */

$tpl = eZTemplate::factory();
$module = $Params['Module'];

$session = ezcPersistentSessionInstance::get();

$q = $session->createFindQuery( 'ezpRestClient' );
$q->where( $q->expr->eq( 'version', ezpRestClient::STATUS_PUBLISHED ) )
  ->orderBy( 'name', ezcQuerySelect::ASC );
$tpl->setVariable( 'applications', $session->find( $q, 'ezpRestClient' ) );

$tpl->setVariable( 'module', $module );

$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/oauthadmin', 'oAuth admin' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/oauthadmin', 'Registered REST applications' ) ) );

$Result['content'] = $tpl->fetch( 'design:oauthadmin/list.tpl' );

return $Result;
?>
