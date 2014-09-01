<?php 
//
// Created on: <Thu Feb 16 10:12:34 CET 2006 ls@ez.no>
//
// Copyright (C) 1999-2008 eZ Systems as. All rights reserved.
//
// This source file is part of the eZ Publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// 'GNU General Public License' version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid 'eZ Publish professional licence' version 2
// may use this file in accordance with the 'eZ Publish professional licence'
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The 'eZ Publish professional licence' version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The 'GNU General Public License' (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

$Module = array( 'name' => 'authorcontact' );

$ViewList = array();
$ViewList['form'] = array( 'script' => 'form.php',
                           'default_navigation_part' => 'ezcustomnavigationpart',
                           'params' => array( 'user_id' => 'UserID', 'node_id' => 'NodeID' ) );
$ViewList['formprocess'] = array( 'script' => 'formprocess.php',
                                  'default_navigation_part' => 'ezcustomnavigationpart',
                                  'single_post_actions' => array( 'SendButton' => 'Send', 'CancelButton' => 'Cancel', 'BackButton' => 'Back' ) );

?>