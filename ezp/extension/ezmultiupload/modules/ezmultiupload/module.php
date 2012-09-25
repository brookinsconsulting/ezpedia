<?php
/**
 * File containing the eZ Publish module definition.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 1.0.0
 * @package ezmultiupload
 */

$Module = array( 'name' => 'eZ Multiupload', 'variable_params' => true );

$ViewList = array();
$ViewList['upload'] = array( 'script' => 'upload.php',
                             'single_post_actions' => array( 'UploadButton' => 'Upload' ),
                             'params' => array( 'ParentNodeID' ) );

?>
