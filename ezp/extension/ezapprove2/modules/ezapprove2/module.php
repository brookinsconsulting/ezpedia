<?php
//
// Created on: <15-Dec-2005 06:43:26 hovik>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Approve 2
// SOFTWARE RELEASE: 0.8.0
// COPYRIGHT NOTICE: Copyright (C) 2006-2008 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file module.php
*/

$Module = array( 'name' => 'eZApprove2' );

$ViewList['select_approver'] = array(
    'script' => 'select_approver.php',
    'ui_context' => 'edit',
    'default_navigation_part' => 'ezapprove2',
    'params' => array( "ApproveStatusID", 'Step' ) );

$ViewList['add_approver'] = array(
    'script' => 'add_approver.php',
    'ui_context' => 'edit',
    'default_navigation_part' => 'ezapprove2',
    'params' => array( "ApproveStatusID" ) );

$ViewList['view_approve_list'] = array(
    'script' => 'view_approve_list.php',
    'default_navigation_part' => 'ezapprove2',
    'params' => array( ) );

?>
