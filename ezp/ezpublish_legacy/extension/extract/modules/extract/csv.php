<?php

// Include toolbox
require_once ( "kernel/common/template.php" );

function applyOutputFilter( $tmp, $filtername )
{
    switch( $filtername )
    {
        case "date":
            $tmp = strftime( "%Y-%m-%d", $tmp );
        break;
        case "parent_name":
            $node = eZContentObjectTreeNode::fetch( $tmp );
            if ( $node )
                $tmp = $node->attribute( 'name' );
        break;
        case "parent_nodes":
            $names = array();
            foreach ( $tmp as $node_id )
            {
                $node = eZContentObjectTreeNode::fetch( $node_id );
                if ( $node )
                    $names[] = $node->attribute( 'name' );
            }
            $tmp = join( " ", $names );
        break;
        default:
        break;
    }
    return $tmp;
}

// Array of extra node attributes
$ExtraAttributes = array(
            'ezuser.login' => array(
                        'id' => 'ezuser.login',
                        'exportname' => 'login',
                        'name' => 'Login',
                        'include' => 'kernel/classes/datatypes/ezuser/ezuser.php',
                        'function' => 'fetch'),
            'ezuser.email' => array(
                        'id' => 'ezuser.email',
                        'exportname' => 'email',
                        'name' => 'E-Mail',
                        'include' => 'kernel/classes/datatypes/ezuser/ezuser.php',
                        'function' => 'fetch'),
            'ezuser.password_hash' => array(
                        'id' => 'ezuser.password_hash',
                        'exportname' => 'password',
                        'name' => 'Password',
                        'include' => 'kernel/classes/datatypes/ezuser/ezuser.php',
                        'function' => 'fetch'),
            'ezcontentobject.published' => array(
                        'id' => 'ezcontentobject.published',
                        'exportname' => 'published',
                        'name' => 'Content Object Published Time',
                        'filter' => 'date',
                        'include' => 'kernel/classes/ezcontentobject.php',
                        'function' => 'fetch'),
            'ezcontentobject.modified' => array(
                        'id' => 'ezcontentobject.modified',
                        'exportname' => 'modified',
                        'name' => 'Content Object Modified Time',
                        'filter' => 'date',
                        'include' => 'kernel/classes/ezcontentobject.php',
                        'function' => 'fetch'),
            'ezcontentobject.main_parent_node_id' => array(
                        'id' => 'ezcontentobject.main_parent_node_id',
                        'exportname' => 'parent_name',
                        'name' => 'Content Object Main Parent Name',
                        'filter' => 'parent_name',
                        'include' => 'kernel/classes/ezcontentobject.php',
                        'function' => 'fetch'),
            'ezcontentobject.parent_nodes' => array(
                        'id' => 'ezcontentobject.parent_nodes',
                        'exportname' => 'parent_nodes',
                        'name' => 'Content Object Parent Names',
                        'filter' => 'parent_nodes',
                        'include' => 'kernel/classes/ezcontentobject.php',
                        'function' => 'fetch')
);

// Start module definition
$module =& $Params["Module"];

// Parse HTTP POST variables
$http = eZHTTPTool::instance();
// Access system variables
$sys = eZSys::instance();
// Init template behaviors
$tpl = templateInit();
// Access ini variables
$ini = eZINI::instance();
$ini_bis = eZINI::instance( 'export.ini.append' );

if ( isset( $_SESSION['EXTRACTCSV_OBJECTID_ARRAY'] ) and count( $_SESSION['EXTRACTCSV_OBJECTID_ARRAY'] ) > 0 )
    $hasPreFilledData = true;
else
    $hasPreFilledData = false;

if ( $hasPreFilledData and $http->hasPostVariable( 'RemoveData' ) )
{
    unset( $_SESSION['EXTRACTCSV_OBJECTID_ARRAY'] );

    return $module->redirectTo( 'extract/csv' );

}
$sessionConfig = $http->sessionVariable( 'eZExtractConfig' );
// Set col & row separator
$Separator = $http->hasPostVariable( 'Separator' ) ? $http->postVariable( 'Separator' ) : ',';

$LineSeparator = $http->hasPostVariable( 'LineSeparator' ) ? $http->postVariable( 'LineSeparator' ) : $sys->osType();

$LineSeparatorArray = array( 'win32' => array( 'id' => 'win32', 'value' => "\r\n", 'name' => 'Windows' ),
                'unix' => array( 'id' => 'unix', 'value' => "\n", 'name' => 'Unix' ),
                'mac' => array( 'id' => 'mac', 'value' => "\r", 'name' => 'Mac' ),
);

$tpl->setVariable( 'Separator', $Separator );
$tpl->setVariable( 'LineSeparator', $LineSeparator );
$tpl->setVariable( 'LineSeparatorArray', $LineSeparatorArray );

// Set limit & offset
$Limit = $http->hasPostVariable( 'Limit' ) ? $http->postVariable( 'Limit' ) : $ini_bis->variable( 'ExportSettings', 'Limit' );
$Offset = $http->hasPostVariable( 'Offset' ) ? $http->postVariable( 'Offset' ) : $ini_bis->variable( 'ExportSettings', 'Offset' );

$tpl->setVariable( 'Limit', $Limit );
$tpl->setVariable( 'Offset', $Offset );

// What is the default subtree
if ( !$http->hasPostVariable( 'Subtree' ) )
{
    $Subtree = ($ini_bis->variable('ExportSettings','StartNodeID' ) == '') ? $ini->variable('UserSettings', 'DefaultUserPlacement' ) : $ini_bis->variable( 'ExportSettings', 'StartNodeID' );
}
else
{
    $Subtree = $http->postVariable( 'Subtree' );
}
// What is the default fetch type
if ( !$http->hasPostVariable( 'type' ) )
{
    $type = 'tree';
}
else
{
    $type = $http->postVariable( 'type' );
}

if ( $type == 'list' )
    $depth['field'] = 1;
else
    $depth = false;

if ( !$http->hasPostVariable( 'mainnodeonly' ) )
{
    $Mainnodeonly = '0';
}
else
{
    $Mainnodeonly = $http->postVariable( 'mainnodeonly' );
}

if ( !$http->hasPostVariable( 'Escape' ) )
{
    $Escape = true;
}
else
{
    if ( $http->postVariable( 'Escape' ) )
       $Escape = true;
    else
       $Escape = false;
}

if ( !$hasPreFilledData )
{
    // What is the default class
    if ( !$http->hasPostVariable( 'Class_id' ) )
    {
       $Class_id = ($ini_bis->variable( 'ExportSettings', 'DefaultClassID' ) == '') ? $ini->variable( 'UserSettings', 'UserClassID' ) : $ini_bis->variable( 'ExportSettings', 'DefaultClassID' );
    }
    else
    {
       $Class_id = $http->postVariable( 'Class_id' );
    }
}
else
{
    $obj = eZContentObject::fetch( $_SESSION['EXTRACTCSV_OBJECTID_ARRAY'][0] );
    $Class_id = $obj->attribute( 'contentclass_id' );
}


if ( $http->hasPostVariable( 'SelectedNodeIDArray' ) )
{
    $nodes = $http->postVariable( 'SelectedNodeIDArray' );
    $Subtree = $nodes[0];
}

// If we don't remove, add or download then or we load all attributes or we start empty
if ( $http->hasPostVariable( 'Remove' ) || $http->hasPostVariable( 'AddAttribute' ) || $http->hasPostVariable( 'Download' ) )
{
    $Attributes = $http->postVariable( 'Attributes' );
}
else
{
    if ( array_key_exists( 'Attributes', $sessionConfig ) and array_key_exists( $Class_id, $sessionConfig['Attributes'] ) )
    {
        $Attributes = $sessionConfig['Attributes'][$Class_id];
    }
    else if ( $ini_bis->variable( 'ExportSettings', 'PreselectAttributes' ) == 'false' )
    {
        $Attributes = array();
    }
    else
    {
        $contentAttributeList = eZContentClassAttribute::fetchListByClassID( $Class_id, eZContentClass::VERSION_STATUS_DEFINED, true );

        foreach( $contentAttributeList as $classattribute )
        {
            $Attributes[] = array(   'id' => $classattribute->attribute( 'identifier' ),
                                     'name' => $classattribute->attribute( 'name' ), 'exportname' => $classattribute->attribute( 'identifier' ) );
        }
    }
}

// Add attribute action that modify previous array
if ( $http->hasPostVariable( 'AddAttribute' ) )
{
    $addID = $http->postVariable( 'AddAttributeID');

    if ( is_numeric( $addID ) )
    {
        $attribute = eZContentClassAttribute::fetch( $addID );
        $element = array( 'id' => $attribute->attribute( 'identifier' ), 'name' => $attribute->attribute( 'name' ), 'exportname' => $attribute->attribute( 'identifier' ) );
        $Attributes[] = $element;
    }
    else
    {
        $Attributes[] = $ExtraAttributes[$addID];
    }
}

// Remove action that modify previous array
if ( $http->hasPostVariable( 'Remove' ) && $http->hasPostVariable( 'RemoveIDArray' ) )
{
    $AttributesClean = array();

    $Removes = $http->postVariable( 'RemoveIDArray' );

    for( $i=0; $i < count( $Attributes ); $i++ )
    {
        if ( !in_array( $i, $Removes ) )
            $AttributesClean[] = $Attributes[$i];
    }
    $Attributes = $AttributesClean;
}

$sessionConfig['Attributes'][$Class_id] = $Attributes;
$http->setSessionVariable( 'eZExtractConfig', $sessionConfig );
// Put above vars in tpl
$tpl->setVariable( 'Type', $type );
$tpl->setVariable( 'Subtree', $Subtree );
$tpl->setVariable( 'Class_id', $Class_id );
$tpl->setVariable( 'Attributes', $Attributes );
$tpl->setVariable( 'ExtraAttributes', $ExtraAttributes );
$tpl->setVariable( 'Mainnodeonly', $Mainnodeonly );
$tpl->setVariable( 'has_prefilledata', $hasPreFilledData );
$tpl->setVariable( 'Escape', $Escape );

$fCollection = new eZContentFunctionCollection();
$list = $fCollection->fetchObjectTreeCount( $Subtree, false, false, 'include', array( $Class_id ),
                                            false, false, false,
                                            false, false, true, false, false );
$tpl->setVariable( 'max_count', $list['result'] + 1 );
// Handle download action
if ( $http->hasPostVariable( 'Download' ) )
{
    #include_once('lib/ezfile/classes/ezfile.php');

    $dir =  eZSys::cacheDirectory().'/';
    $file = $dir . 'export.csv';

    $row = "";
    $first = true;
    foreach( $Attributes as $item )
    {
        if ( $first )
          $first = false;
        else
          $row .= $Separator;

        $row .= $item['exportname'];
    }

    $data = $row . $LineSeparatorArray[$LineSeparator]['value'];

    if ( $hasPreFilledData )
    {
        $list = $http->sessionVariable( 'EXTRACTCSV_OBJECTID_ARRAY' );
    }
    else
    {
        // Retrieve parent_node_id sort_array
        $node = eZContentObjectTreeNode::fetch( $Subtree );
        $sortBy = $node->sortArray();
        $sortBy = $sortBy[0];

        $groupBy = null;

        $list2 = $fCollection->fetchObjectTree( $Subtree, $sortBy, false, false, $Offset, $Limit, $depth, false,
                                                $Class_id, false, false, 'include', array( $Class_id ),
                                                $groupBy, $Mainnodeonly, true, array(), true, false, true );

        $list = $list2['result'];
    }

    $parser = new ParserInterface( $Separator, $Escape );

    foreach( $list as $item )
    {
        $row = '';
        if ( is_object( $item ) )
            $obj = $item->attribute( 'object' );
        else
            $obj = eZContentObject::fetch( $item );
        if ( !is_object( $obj ) )
            continue;
        $datamap = $obj->attribute( 'data_map' );
        # include_once( 'extension/extract/classes/parserinterface.php' );

        $first = true;

        foreach( $Attributes as $dataelement )
        {
            $found = false;

            if ( is_object( $datamap[$dataelement['id']] ) )
            {
                $row .= $parser->exportAttribute( $datamap[ $dataelement['id'] ] );
            }
            else if ( preg_match( '#(.*)\.(.*)#', $dataelement['id'], $matches ) )
            {
                #include_once($ExtraAttributes[$dataelement['id']]['include']);

                $id = $obj->attribute('id');
                $tmp = new $matches[1];
                $tmp = $tmp->$ExtraAttributes[$dataelement['id']]['function']($id);

                if ( array_key_exists( 'filter', $ExtraAttributes[$dataelement['id']] ) )
                {
                    $tmp = applyOutputFilter( $tmp->attribute($matches[2]),
                                              $ExtraAttributes[$dataelement['id']]['filter'] );
                }

                if ( $first )
                    $first = false;
                else
                    $row .= $Separator;
                if ( is_object( $tmp ) )
                    $row .=  $parser->escape( $tmp->attribute( $matches[2] ) );
                else
                    $row .=  $parser->escape( $tmp );

                unset( $tmp );
            }
            else
            {
                $row .= $Separator;
            }
        }
        $data .= $row . $LineSeparatorArray[$LineSeparator]['value'];
    }

    @unlink( $file );
    eZFile::create( $file, false, $data );

    if ( !eZFile::download( $file ) )
        $module->redirectTo( 'content/view/full/5' );
}

if ( $http->hasPostVariable( 'BrowseSubtree' ) )
{
    $return = eZContentBrowse::browse( array( 'action_name' => 'ExtractionSubtree',
                        'description_template' => 'design:extract/browse_node.tpl',
                        'from_page' => '/extract/csv',
                        'persistent_data' => array( 'Subtree' => $Subtree,
                                        'Class_id' => $Class_id,
                                        'Attributes' => $Attributes,
                                        'LineSeparator' => $LineSeparator,
                                        'Separator' => $Separator ) ),
                           $module );
}

$Result = array();
$Result['content'] = $tpl->fetch( "design:extract/csv.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n('design/standard/extract', 'Extract') ),
                         array( 'url' => false,
                                'text' => ezi18n('design/standard/extract', 'CSV') )
                        );

$Result['left_menu'] = 'design:extract/menu.tpl';

?>