<?php
/**
 * File containing ezcomServerFunctions class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 *
 */

/*
 * ezjscServerFunctions for ezcomments
 */

class ezcomServerFunctions extends ezjscServerFunctions
{

    public static function userData()
    {
        unset( $_COOKIE['eZCommentsUserData'] );
        $cookie = ezcomCookieManager::instance();
        return $cookie->storeCookie();
    }
}
