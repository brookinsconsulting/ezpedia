<?php 
//
// Created on: <Thu Feb 16 10:15:04 CET 2006 ls@ez.no>
//
// Copyright (C) 1999-2006 eZ Systems as. All rights reserved.
//
// This source file is part of the eZ Publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ Publish professional licence" version 2
// may use this file in accordance with the "eZ Publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ Publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'kernel/common/template.php' );

$Module =& $Params['Module'];
$parameters = $Params['Parameters'];

$nodeID = 0;
$userID = 0;

$http = eZHTTPTool::instance();
$tpl = templateInit();

if ( isset( $parameters['validation'] ) )
{
	$validation = $parameters['validation'];
}
else
{
	$validation['processed'] = false;
}

if ( isset( $parameters['user_id'] ) )
	$userID = $parameters['user_id'];

if ( isset( $parameters['node_id'] ) )
	$nodeID = $parameters['node_id'];

if ( is_numeric( $Params['UserID'] ) )
	$userID = $Params['UserID'];

if ( is_numeric( $Params['NodeID'] ) )
	$nodeID = $Params['NodeID'];

/*
  print_r( $nodeID ); echo "<hr />";
  print_r( $userID ); echo "<hr />";
*/

$user = eZUser::fetch( $userID );

// Fetch content object
$nodeObject = eZContentObject::fetchByNodeID( $nodeID );

// $nodeObjectID = $nodeObject->attribute('id');
// $contentObjectID = $nodeObjectID;

/*
print_r( $user );
echo "<hr />";
print_r( $nodeObject );
*/

if( $nodeObject )
{
  $nodeObjectName = $nodeObject->attribute('name');
  $nodeObjectOwner = $nodeObject->attribute('owner');
  $nodeObjectOwnerName = $nodeObjectOwner->attribute('name');
  $nodeObjectOwnerID = $nodeObjectOwner->attribute('id');
  $authorName = $nodeObjectOwnerName;
  $contentObjectID = $nodeObjectOwnerID;
}

if ( !$user )
     return $Module->handleError( EZ_ERROR_KERNEL_NOT_FOUND, 'kernel' );

     // $object = $user->attribute( 'contentobject' );
     $object = $nodeObject;

if ( !$object )
     return $Module->handleError( EZ_ERROR_KERNEL_NOT_FOUND, 'kernel' );

        // $authorName = $object->attribute( 'name' );
        // $contentObjectID = $object->attribute( 'id' );


if ( isset( $parameters['name'] ) ) 
{
	$name = $parameters['name'];
	$tpl->setVariable( 'name', $name );
}

if ( isset( $parameters['user_redirect_uri'] ) ) 
{
	$userRedirectURI = $parameters['user_redirect_uri'];
	$tpl->setVariable( 'redirect_uri', $userRedirectURI );
}
else 
{
	if( isset( $GLOBALS['HTTP_SERVER_VARS']['HTTP_REFERER'] ) )
	{
		$userRedirectURI = $GLOBALS['HTTP_SERVER_VARS']['HTTP_REFERER'];
		$tpl->setVariable( 'redirect_uri', $userRedirectURI );
	}
}

if ( isset( $parameters['email'] ) ) 
{
	$email = $parameters['email'];
	$tpl->setVariable( 'email', $email );
}

if ( isset( $parameters['subject'] ) ) 
{
	$subject = $parameters['subject'];
	$tpl->setVariable( 'subject', $subject );
}

if ( isset( $parameters['message'] ) ) 
{
	$message = $parameters['message'];
	$tpl->setVariable( 'message', $message );
}
else {
	$tpl->setVariable( 'message', false );
}

$tpl->setVariable( 'author_name', $authorName );
$tpl->setVariable( 'object_id', $contentObjectID );
$tpl->setVariable( 'node_id', $nodeID );

$tpl->setVariable( 'validation', $validation );

$Result = array();

if ( $userID == 14 )
{
    $Result['content'] = $tpl->fetch( 'design:user/login.tpl' );
}
else {
    $Result['content'] = $tpl->fetch( 'design:authorconnect/form.tpl' );
}

$Result['left_menu'] = 'design:authorconnect/left_info.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'extension/authorconnect', 'Contact ' ) . $authorName ) );

?>