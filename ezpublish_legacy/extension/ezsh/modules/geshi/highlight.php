<?php
/**
* View used to highlight any file (optionally: only within the eZP root diir)
* @author G. Giunta
* @copyright (c) G. Giunta 2010-2012
* @license code licensed under the GPL License: see README
*/

$Module = $Params['Module'];
$orig_filename = implode( '/', $Params['Parameters'] );
$filename = $orig_filename;
$language = isset( $Params['language'] ) ? $Params['language'] : '';

$ezpath = str_replace( '\\', '/', eZSys::rootDir() );

$ini = eZINI::instance( 'ezsh.ini' );

// start assuming a relative path, unless it looks like an absolute one
/// @todo windows support: unc paths
if ( $filename[0] != '/' && !preg_match( '#^[a-zA-Z]:[/\\\\]#', $filename ) )
{
    $filename = $ezpath . '/' . $filename;
}
else if ( $ini->variable( 'GeneralSettings', 'AllowAbsolutePaths' ) !== 'enabled' )
{
    // safety measure: only allow access via absolute path if configured so
    return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}

$filepath = str_replace( '\\', '/', realpath( $filename ) );

// safety measure: check if file is not within ez root dir, if it is not user
// needs to have a specific permission
$user = eZUser::currentUser();
if ( !$user->hasAccessTo( 'geshi', 'view_any_source' ) )
{
    if ( strpos( $ezpath, $filepath ) !== 0 )
    {
        return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
    }
}

// safety measure 2: check blacklisted files / dirs
foreach( $ini->variable( 'GeneralSettings', 'Blacklist' ) as $forbiddenfile )
{
    if ( $forbiddenfile[0] != '/' && !preg_match( '#^[a-zA-Z]:[/\\\\]#', $forbiddenfile ) )
    {
        $forbiddenfile = $ezpath . '/' . $forbiddenfile;
    }
    $forbiddenfile = str_replace( '#', '\#', $forbiddenfile );

    if ( preg_match( "#^$forbiddenfile$#", $filepath ) )
    {
        return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
    }
}

$errormsg = false;
$highlighted = '';
if ( is_file( $filename ) )
{
    //include_once( 'extension/ezsh/lib/geshi/geshi.php' );

    $source = file_get_contents( $filename );
    $geshi = new GeSHi( $source, $language );
    if ( $language == '' && strpos( $filename, '.' ) !== false )
    {
        $ext = substr( strrchr( $filename, '.' ), 1 );
        $ez_langs = array(
            'ini' => 'ezini',
            'tpl' => 'eztemplate',
            'append' => 'ezini',
            'htaccess' => 'apache',
            'htaccess_root' => 'apache',
            'php-RECOMMENDED' => 'php',
        );
        if ( array_key_exists( $ext, $ez_langs ) )
        {
            $language = $ez_langs[$ext];
        }
        else if( $ext == 'php' && strpos( $filename, '/settings/' ) !== false )
        {
            $language = 'ezini';
        }
        else if ( $ext == 'sql' && ( strpos( $filename, '/oracle/' ) !== false || strpos( $filename, '/ezoracle/' ) !== false ) )
        {
            $language = 'oracle11';
        }
        else if ( $orig_filename == 'robots.txt' )
        {
            $language = 'robots';
        }
        else
        {
            $language = $geshi->get_language_name_from_extension( $ext );
        }
        $geshi->set_language( $language );
    }

    $highlighted = $geshi->parse_code();
    // temp fix for weird results from ezini lang results
    if ( substr( $highlighted, 0, 90 ) == '<pre class="ezini" style="font-family:monospace;">span style="background-color: yellow;"> ')
    {
        $highlighted = '<pre class="ezini" style="font-family:monospace;"><span>' . substr( $highlighted, 90 );
    }
    $error = $geshi->error();
    if ( $error != false )
    {
        $errormsg = strip_tags( $error );
        eZDebug::writeWarning( 'In view geshi/highligt: ' . $errormsg, __FILE__ );
    }
}
else
{
    $errormsg = "File $orig_filename nout found";
}

require_once( "kernel/common/template.php" );
$tpl = templateInit();
$tpl->setVariable( 'filename', $orig_filename );
$tpl->setVariable( 'language', $language );
$tpl->setVariable( 'highlighted', $highlighted );
$tpl->setVariable( 'errormsg', $errormsg );

$Result = array();
$Result['content'] = $tpl->fetch( "design:geshi/highlight.tpl" );

$Result['path'] = array( array( 'url' => false,
                                'text' => 'Highlight' ) );

?>