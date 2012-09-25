<?php
/**
 * File containing ezcomCommentsInfo class
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

class ezcommentsInfo
{
    static function info()
    {
        return array(
            'Name' => "<a href='http://projects.ez.no/ezcomments'>eZ Comments</a>",
            'Version' => "1.2.0",
            'Copyright' => 'Copyright (C) 1999-2011 eZ Systems AS',
            'License' => 'GNU General Public License v2.0',
            'Includes the following third-party software' => array( 'Name' => 'reCAPTCHA PHP Library',
                                                                              'Version' => '1.11',
                                                                              'Copyright' => 'Copyright (c) 2007 reCAPTCHA -- http://recaptcha.net',
                                                                              'License' => '',)
        );
    }
}
?>
