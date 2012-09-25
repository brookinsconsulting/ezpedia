<?php
/**
 * File containing ezcomServerFunctions class
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
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
