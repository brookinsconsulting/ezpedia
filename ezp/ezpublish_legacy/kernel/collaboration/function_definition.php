<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 * @package kernel
 */

$FunctionList = array();
$FunctionList['participant'] = array( 'name' => 'participant',
                                      'operation_types' => array( 'read' ),
                                      'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                              'method' => 'fetchParticipant' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array( array( 'name' => 'item_id',
                                                                    'required' => true,
                                                                    'default' => false ),
                                                             array( 'name' => 'participant_id',
                                                                    'required' => false,
                                                                    'default' => false ) ) );
$FunctionList['participant_list'] = array( 'name' => 'participant_list',
                                           'operation_types' => array( 'read' ),
                                           'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                                   'method' => 'fetchParticipantList' ),
                                           'parameter_type' => 'standard',
                                           'parameters' => array( array( 'name' => 'item_id',
                                                                         'required' => false,
                                                                         'default' => false ),
                                                                  array( 'name' => 'sort_by',
                                                                         'required' => false,
                                                                         'default' => false ),
                                                                  array( 'name' => 'offset',
                                                                         'required' => false,
                                                                         'default' => false ),
                                                                  array( 'name' => 'limit',
                                                                         'required' => false,
                                                                         'default' => false ) ) );
$FunctionList['participant_map'] = array( 'name' => 'participant_map',
                                          'operation_types' => array( 'read' ),
                                          'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                                  'method' => 'fetchParticipantMap' ),
                                           'parameter_type' => 'standard',
                                          'parameters' => array( array( 'name' => 'item_id',
                                                                        'required' => false,
                                                                        'default' => false ),
                                                                 array( 'name' => 'sort_by',
                                                                        'required' => false,
                                                                        'default' => false ),
                                                                 array( 'name' => 'offset',
                                                                        'required' => false,
                                                                        'default' => false ),
                                                                 array( 'name' => 'limit',
                                                                        'required' => false,
                                                                        'default' => false ),
                                                                 array( 'name' => 'field',
                                                                        'required' => false,
                                                                        'default' => false ) ) );
$FunctionList['message_list'] = array( 'name' => 'message_list',
                                       'operation_types' => array( 'read' ),
                                       'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                               'method' => 'fetchMessageList' ),
                                       'parameter_type' => 'standard',
                                       'parameters' => array( array( 'name' => 'item_id',
                                                                     'required' => true,
                                                                     'default' => false ),
                                                              array( 'name' => 'sort_by',
                                                                     'required' => false,
                                                                     'default' => false ),
                                                              array( 'name' => 'offset',
                                                                     'required' => false,
                                                                     'default' => false ),
                                                              array( 'name' => 'limit',
                                                                     'required' => false,
                                                                     'default' => false ) ) );
$FunctionList['item_list'] = array( 'name' => 'item_list',
                                    'operation_types' => array( 'read' ),
                                    'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                            'method' => 'fetchItemList' ),
                                    'parameter_type' => 'standard',
                                    'parameters' => array( array( 'name' => 'sort_by',
                                                                  'required' => false,
                                                                  'default' => false ),
                                                           array( 'name' => 'offset',
                                                                  'required' => false,
                                                                  'default' => false ),
                                                           array( 'name' => 'limit',
                                                                  'required' => false,
                                                                  'default' => false ),
                                                           array( 'name' => 'status',
                                                                  'required' => false,
                                                                  'default' => false ),
                                                           array( 'name' => 'is_read',
                                                                  'required' => false,
                                                                  'default' => null ),
                                                           array( 'name' => 'is_active',
                                                                  'required' => false,
                                                                  'default' => null ),
                                                           array( 'name' => 'parent_group_id',
                                                                  'required' => false,
                                                                  'default' => null ) ) );
$FunctionList['item_count'] = array( 'name' => 'item_count',
                                     'operation_types' => array( 'read' ),
                                     'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                             'method' => 'fetchItemCount' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array( array( 'name' => 'is_read',
                                                                   'required' => false,
                                                                   'default' => null ),
                                                            array( 'name' => 'is_active',
                                                                   'required' => false,
                                                                   'default' => null ),
                                                            array( 'name' => 'parent_group_id',
                                                                   'required' => false,
                                                                   'default' => null ),
                                                            array( 'name' => 'status',
                                                                   'required' => false,
                                                                   'default' => false ) ) );
$FunctionList['group_tree'] = array( 'name' => 'group_tree',
                               'operation_types' => array( 'read' ),
                               'call_method' => array( 'class' => 'eZCollaborationFunctionCollection',
                                                       'method' => 'fetchGroupTree' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'parent_group_id',
                                                             'required' => true ),
                                                      array( 'name' => 'sort_by',
                                                             'required' => false,
                                                             'default' => false ),
                                                      array( 'name' => 'offset',
                                                             'required' => false,
                                                             'default' => false ),
                                                      array( 'name' => 'limit',
                                                             'required' => false,
                                                             'default' => false ),
                                                      array( 'name' => 'depth',
                                                             'required' => false,
                                                             'default' => false ) ) );

$FunctionList['tree_count'] = array( 'name' => 'tree_count',
                                     'operation_types' => array( 'read' ),
                                     'call_method' => array( 'class' => 'eZContentFunctionCollection',
                                                             'method' => 'fetchObjectTreeCount' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array( array( 'name' => 'parent_node_id',
                                                                   'required' => true ),
                                                            array( 'name' => 'class_filter_type',
                                                                   'required' => false,
                                                                   'default' => false ),
                                                            array( 'name' => 'class_filter_array',
                                                                   'required' => false,
                                                                   'default' => false ),
                                                            array( 'name' => 'depth',
                                                                   'required' => false,
                                                                   'default' => 0 ) ) );

?>
