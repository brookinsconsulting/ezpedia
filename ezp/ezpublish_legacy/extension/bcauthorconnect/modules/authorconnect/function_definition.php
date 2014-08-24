<?php
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

$FunctionList = array();

$FunctionList['form'] = array( 'name' => 'form',
                               'operation_types' => array( 'read' ),
                               'call_method' => array( 'include_file' =>
                                                       'extension/bcauthorconnect/modules/authorconnect/authorconnectfunctioncollection.php',
                                                       'class' => 'AuthorConnectFunctionCollection',
                                                       'method' => 'fetchAuthorConnectForm' ),
                               'parameter_type' => 'standard',
                               'parameters' => array(
                                                     array( 'name' => 'user_id',
                                                            'type' => 'integer',
                                                            'required' => false ),
                                                     array( 'name' => 'node_id',
                                                            'type' => 'integer',
                                                            'required' => false )
                                                     )
                               );

/*
$FunctionList['form'] = array( 'name' => 'form',
                                      'operation_types' => array( 'read' ),
                                      'call_method' => array( 'include_file' =>
                                                              'extension/bceventcalendar/modules/authorcontact/authorcontactfunctioncollection.php',
                                                              'class' => 'AuthorContactFunctionCollection',
                                                              'method' => 'fetchAuthorContactForm' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array( array( 'name' => 'id',
                                                                    'type' => 'integer',
                                                                    'required' => true ) ) );
*/

?>