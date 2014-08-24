<?php
$Module =& $Params['Module'];
$http = eZHTTPTool::instance();

include_once( 'kernel/classes/ezpreferences.php' );
include_once( 'kernel/common/template.php' );
$tpl = templateInit();

$db = eZDB::instance();

if ( $http->postVariable( 'SiteAccess') and $http->postVariable( 'ObjectID') )
{
    $path = eZSys::indexDir( false ) . '/' . $http->postVariable( 'SiteAccess') . '/admin/changeuser/'. $http->postVariable( 'ObjectID');
    eZHTTPTool::redirect( $path );
    eZExecution::cleanExit();
}
if ( isset( $Params['UserParameters'] ) )
    $UserParameters = $Params['UserParameters'];
else
    $UserParameters = array();

if ( $Params['Offset'] )
    $Offset = (int) $Params['Offset'];

if ( $http->postVariable( 'search_text') )
{
    $search_text = $http->postVariable( 'search_text');
}
elseif ( $UserParameters['search_text'] )
{
    $search_text = $UserParameters['search_text'];
}
$viewParameters = array( 'offset' => $Offset, 'search_text' => $search_text );
$viewParameters = array_merge( $viewParameters, $UserParameters );

switch ( eZPreferences::value( 'changeuser_list_limit' ) )
{
    case '2': { $limit = 25; } break;
    case '3': { $limit = 50; } break;
    default:  { $limit = 10; } break;
}

$result = $db->arrayQuery( "SELECT ezcontentclass.identifier, ezcontentclass.id FROM ezcontentclass_attribute,ezcontentclass WHERE 
ezcontentclass_attribute.contentclass_id = ezcontentclass.id
 AND data_type_string='ezuser'" );

foreach( $result as $row )
{
    $identifiers[] = $row['identifier'];
    $ids[] = $row['id']; 
}

$identifiers = array_unique( $identifiers );

include_once( 'extension/ezadmin/classes/ezuseraddition.php' );


$tpl->setVariable( 'recall', eZUserAddition::recallUserID() );
$tpl->setVariable( 'identifiers', $identifiers );
$tpl->setVariable( 'ids', $ids );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'current_siteaccess', $GLOBALS['eZCurrentAccess']['name'] );
$tpl->setVariable( 'search_text', $search_text );

$Result = array();
$Result['left_menu'] = "design:parts/ezadmin/menu.tpl";
$Result['content'] = $tpl->fetch( "design:ezadmin/changeuserview.tpl" );
$Result['path'] = array( array( 'url' => false,
                        'text' => 'Change User' ) );
?>