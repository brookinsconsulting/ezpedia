<?php
include_once( "kernel/common/template.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );

$Module =& $Params['Module'];
$sys  = eZSys::instance();
$tpl = templateInit();
$ini = eZINI::instance();

$http = eZHTTPTool::instance();

$output = "";
if ( $Module->isCurrentAction( 'Cancel' ) )
{
        $Module->redirectTo( 'admin/menu' );
}

if ( $http->hasPostVariable( 'Run' ) )
{
        include_once( 'lib/ezlocale/classes/ezdatetime.php' );
        $time =  new eZDateTime();
        $subject = "Test mail " . $time->toString();

        include_once( 'lib/ezutils/classes/ezmail.php' );
        include_once( 'lib/ezutils/classes/ezmailtransport.php' );
        $mail = new eZMail();

        // Sender might not be given by default settings
        if ( $ini->variable( 'MailSettings', 'EmailSender' ) )
            $mail->setSender( $ini->variable( 'MailSettings', 'EmailSender' ) );
        else
            $mail->setSender( $ini->variable( 'MailSettings', 'AdminEmail' ) );

        $mail->setReceiver( $http->postVariable( 'To' ) );
        $mail->setBody( $subject."\n\nNew line test.\nMessage End." );
        $mail->setSubject( $subject );

        $response = eZMailTransport::send( $mail );
	
	   // check if the server returned a fault, if not print out the result
	   if ($response=== true)
	       $output = "Success when sending on " . $time->toString();
	   else
	   {

	       $output = "Not success when sending on " . $time->toString() .". Please see debug output.";
	   }
}

$tpl->setVariable( 'Output' , $output );


if ( $http->hasPostVariable( 'To' ) )
	$tpl->setVariable( 'To' , $http->postVariable( 'To' ) );
else
    $tpl->setVariable( 'To' , $ini->variable( 'MailSettings', 'AdminEmail' ) );

$Result = array();
$Result['left_menu'] = "design:parts/ezadmin/menu.tpl";
$Result['content'] = $tpl->fetch( "design:ezadmin/mailtest.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'extension/admin', 'SOAP test webclient' ) ) );

?>
