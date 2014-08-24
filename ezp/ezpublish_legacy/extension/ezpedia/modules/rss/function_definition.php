<?php
/**
 * File containing the RSS function definitions.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 * @package kernel
 */

$FunctionList = array();

$FunctionList['has_export_by_node'] = array( 'name' => 'has_node_map',
                               'operation_types' => array( 'read' ),
                               'call_method' => array( 'class' => 'eZRSSFunctionCollection',
                                                       'method' => 'hasExportByNode' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'node_id',
                                                             'type' => 'integer',
                                                             'required' => true ) ) );
$FunctionList['export_by_node'] = array( 'name' => 'node_map',
                                   'operation_types' => array( 'read' ),
                                   'call_method' => array( 'class' => 'eZRSSFunctionCollection',
                                                           'method' => 'exportByNode' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array( array( 'name' => 'node_id',
                                                                 'type' => 'integer',
                                                                 'required' => true ) ) );

$FunctionList['list'] = array( 'name' => 'list',
                               'operation_types' => 'read',
                               'call_method' => array( 'class' => 'eZRSSFunctionCollection',
                                                       'method' => 'fetchList' ),
                               'parameter_type' => 'standard',
                               'parameters' => array() );

$FunctionList['subtree_list'] = array( 'name' => 'subtree_list',
                                       'operation_types' => 'read',
                                       'call_method' => array( 'class' => 'eZRSSFunctionCollection',
                                                               'method' => 'fetchSubtreeList' ),
                                       'parameter_type' => 'standard',
                                       'parameters' => array( array( 'name' => 'node_id',
                                                                     'type' => 'integer',
                                                                     'required' => true ),
                                                              array( 'name' => 'max_depth',
                                                                     'type' => 'integer',
                                                                     'required' => false ) ) );

?>