<?php 
//
// Created on: <Thu Feb 16 13:35:41 CET 2006 ls@ez.no>
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
include_once( 'lib/ezutils/classes/ezmail.php' );
include_once( 'lib/ezutils/classes/ezmailtransport.php' );

$Module = $Params["Module"];

$http = eZHTTPTool::instance();
$tpl = templateInit();

$validation = array();
$parameters = array();

if ( $Module->isCurrentAction( 'Send' ) )
{
	if ( $http->hasPostVariable( 'Name' ) )
	{
		$name = $http->postVariable( 'Name' );
		
		if ( $name == '' )
		{
			$validation['processed'] = true;
			$validation['attributes'][] = array( 'name' => ezi18n( 'extension/bcauthorconnect', 'Name' ), 'description' => ezi18n( 'extension/bcauthorconnect', 'Input required.' ) );
		}
		else 
		{
			$parameters['name'] = $name;
		}
	}
	
	if ( $http->hasPostVariable( 'Email' ) )
	{
		$email = $http->postVariable( 'Email' );
		
		if ( $email == '' )
		{
			$validation['processed'] = true;
			$validation['attributes'][] = array( 'name' => ezi18n( 'extension/bcauthorconnect', 'E-mail' ), 'description' => ezi18n( 'extension/bcauthorconnect', 'Input required.' ) );
		}
		else 
		{
			if ( !eZMail::validate( $email ) )
			{
				$validation['processed'] = true;
				$validation['attributes'][] = array( 'name' => ezi18n( 'extension/bcauthorconnect', 'E-mail' ), 'description' => ezi18n( 'extension/bcauthorconnect', 'Invalid address syntax.' ) );
			}
			
			$parameters['email'] = $email;
		}
	}
	
	if ( $http->hasPostVariable( 'Subject' ) )
	{
		$subject = $http->postVariable( 'Subject' );
		
		if ( $subject == '' )
		{
			$validation['processed'] = true;
			$validation['attributes'][] = array( 'name' => ezi18n( 'extension/bcauthorconnect', 'Subject' ), 'description' => ezi18n( 'extension/bcauthorconnect', 'Input required.' ) );			
		}
		else 
		{
			$parameters['subject'] = $subject;
		}
	}
	
	if ( $http->hasPostVariable( 'Message' ) )
	{
		$message = $http->postVariable( 'Message' );
		
		if ( $message == '' )
		{
			$validation['processed'] = true;
			$validation['attributes'][] = array( 'name' => ezi18n( 'extension/bcauthorconnect', 'Message' ), 'description' => ezi18n( 'extension/bcauthorconnect', 'Input required.' ) );			
		}
		else 
		{
			$parameters['message'] = $message;
		}
	}
	
	if ( $http->hasPostVariable( 'ContentObjectID' ) )
	{
		$objectID = $http->postVariable( 'ContentObjectID' );
		$parameters['user_id'] = $objectID;
	}

	if ( $http->hasPostVariable( 'ContentNodeID' ) )
	{
		$nodeID = $http->postVariable( 'ContentNodeID' );
		$parameters['node_id'] = $nodeID;

		$tpl->setVariable( 'node_id', $nodeID );
	}

	if ( $http->hasPostVariable( 'UserRedirectURI' ) )
	{
		$userRedirectURI = $http->postVariable( 'UserRedirectURI' );
		$parameters['user_redirect_uri'] = $userRedirectURI;
		
		$tpl->setVariable( 'redirect_uri', $userRedirectURI );
	}

	if ( !empty( $validation ) ) 
	{
		$parameters['validation'] = $validation;
		
		return $Module->run( 'form', $parameters );
	}
	
	$mail = new eZMail();
	
	$user = eZUser::fetch( $objectID );

	$mail->setReceiver( $user->attribute( 'email' ) );
	$mail->setSender( $email, $name );
	$mail->setSubject( $subject );
	$mail->setBody( $message );
	$mailResult = eZMailTransport::send( $mail );

	$tpl->setVariable( 'mail_result', $mailResult );
}

if ( $Module->isCurrentAction( 'Cancel' ) )
{
	$contentNodeID = $http->postVariable( 'ContentNodeID' );
	$node = eZContentObjectTreeNode::fetch( $contentNodeID );
	
	if ( $node )
	{
		return $Module->redirectTo( '/content/view/full/' . $contentNodeID );
	}
	else
	{
		if ( $http->hasPostVariable( 'UserRedirectURI' ) )
		{
			$userRedirectURI = $http->postVariable( 'UserRedirectURI' );
			return $Module->redirectTo( $userRedirectURI );
		}
	}
}

if ( $Module->isCurrentAction( 'Back' ) )
{
	$contentNodeID = $http->postVariable( 'ContentNodeID' );
	$node = eZContentObjectTreeNode::fetch( $contentNodeID );
	
	if ( $node )
	{
		return $Module->redirectTo( '/content/view/full/' . $contentNodeID );
	}
	else
	{
		if ( $http->hasPostVariable( 'UserRedirectURI' ) )
		{
			$userRedirectURI = $http->postVariable( 'UserRedirectURI' );
			return $Module->redirectTo( $userRedirectURI );
		}
	}
}


$Result = array();
$Result['content'] = $tpl->fetch( 'design:authorconnect/formprocess.tpl' );
$Result['left_menu'] = 'design:authorconnect/left_info.tpl';
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'extension/bcauthorconnect', 'Thank you' ) ) );

?>