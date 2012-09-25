<?php

$Module = array('name' => 'Extract');

$ViewList = array();
$ViewList['csv'] = array( 'script' => 'csv.php',
            			  'default_navigation_part' => 'ezextractnavigationpart',
            			  'post_actions' => array( 'Download', 'BrowseSubtree', 'AddAttribute', 'Remove', 'RemoveData' ),
            			  'params' => array() );
?>
