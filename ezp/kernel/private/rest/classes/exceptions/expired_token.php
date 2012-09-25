<?php
/**
 * File containing the ezpOauthTokenNotFoundException class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 *
 */

/**
 * This exception is thrown when the accept token has expired, but can be
 * renewed.
 *
 * @package oauth
 */
class ezpOauthExpiredTokenException extends ezpOauthRequiredException
{
    public function __construct( $message )
    {
        $this->errorType = ezpOauthErrorType::EXPIRED_TOKEN;
        parent::__construct( $message );
    }
}
?>
