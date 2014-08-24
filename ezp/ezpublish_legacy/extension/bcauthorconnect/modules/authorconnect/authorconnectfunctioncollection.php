<?php
//
// Definition of AuthorConnectFunctionCollection class
//
// Created on: <23-Feb-2008 22:20:00 gb>
//
// Copyright (C) 1999-2008 Brookins Consulting. All rights reserved.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 or later as published by
// the Free Software Foundation and appearing in the file LICENSE
// included in the packaging of this file.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@brookinsconsulting.com if any conditions
// of this licencing isn't clear to you.
//

/*! \file authorconnectfunctioncollection.php
*/

/*!
  \class AuthorConnectFunctionCollection authorconnectfunctioncollection.php
  \brief The class AuthorConnectFunctionCollection does provide owner notification rule creation after publish
*/

class AuthorConnectFunctionCollection
{
    /*!
     Constructor
    */
    function AuthorConnectFunctionCollection()
    {
    }

    /*!
     Fetch Author Connect Form
    */
    function fetchAuthorConnectForm( $user_id, $node_id )
    {

        include_once( 'kernel/classes/ezcontentobject.php' );
        include_once( 'kernel/common/template.php' );

        $parameters = array( 'user_id' => $user_id,
                             'node_id' => $node_id,
                             'anonymous_user_id' => 44 );

        if ( isset( $parameters['user_id'] ) )
            $userID = $parameters['user_id'];

        if ( isset( $parameters['node_id'] ) )
            $nodeID = $parameters['node_id'];

        // Test current user id is not same as anonymous user id
        if ( $userID != $parameters['anonymous_user_id'] )
        {
            // print_r( $userID );
            $user = eZUser::fetch( $userID );
            // print_r( $user );

            // if ( !$user )
                // return $Module->handleError( EZ_ERROR_KERNEL_NOT_FOUND, 'kernel' );

            // print_r($user);

            if ( $user and $user->isLoggedIn() )
            {
                /* $Module =& $Params['Module']; $parameters = $Params['Parameters']; */

                // $nodeID = 0;
                // $userID = 0;

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

                /*
                  if ( isset( $parameters['user_id'] ) )
                       $userID = $parameters['user_id'];

                   if ( isset( $parameters['node_id'] ) )
                       $nodeID = $parameters['node_id'];

                   if ( !$user )
                       return $Module->handleError( EZ_ERROR_KERNEL_NOT_FOUND, 'kernel' );
                */

                $object = $user->attribute( 'contentobject' );

                /*
                if ( !$object )
                    return $Module->handleError( EZ_ERROR_KERNEL_NOT_FOUND, 'kernel' );
                */

                // ?
                $authorName = $object->attribute( 'name' );
                $contentObjectID = $object->attribute( 'id' );
                // print_r($object);

                $tpl->setVariable( 'name', $authorName );
                $tpl->setVariable( 'redirect_uri', false );

                $email = $user->Email;
                $tpl->setVariable( 'email', $email );

                // Fetch content object
                $nodeObject = eZContentObject::fetchByNodeID( $node_id );
                // $nodeObjectID = $nodeObject->attribute('id');
                // $contentObjectID = $nodeObjectID;
                // print_r( $nodeObject );

                $nodeObjectName = $nodeObject->attribute('name');
                $nodeObjectNodeID = $node_id;
                $nodeObjectOwner = $nodeObject->attribute('owner');
                $nodeObjectOwnerName = $nodeObjectOwner->attribute('name');
                $nodeObjectOwnerObjectID = $nodeObjectOwner->attribute('id');
                $authorName = $nodeObjectOwnerName;
                $contentObjectID = $nodeObjectOwnerObjectID;
                // print_r( $nodeObjectOwnerObjectID );

                $subject = 'Re: '. $nodeObjectName;
                $tpl->setVariable( 'subject', $subject );

                $tpl->setVariable( 'message', false );
                $tpl->setVariable( 'author_name', $authorName );
                $tpl->setVariable( 'object_id', $contentObjectID );
                $tpl->setVariable( 'node_id', $nodeID );
                $tpl->setVariable( 'validation', $validation );

                $result = $tpl->fetch( 'design:authorconnect/form.tpl' );
            }
            else
            {
                $result = ' ';
            }
        }
        else
        {
            $result = ' ';
        }
            return array( 'result' => $result );
    }
}

?>