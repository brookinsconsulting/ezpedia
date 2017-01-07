<?php
/**
 * File containing the UserWrapped class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\Core\MVC\Symfony\Security;

use eZ\Publish\API\Repository\Values\User\User as APIUser;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface as CoreUserInterface;

class UserWrapped implements UserInterface, EquatableInterface
{
    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    private $wrappedUser;

    /**
     * @var \eZ\Publish\API\Repository\Values\User\User
     */
    private $apiUser;

    public function __construct( CoreUserInterface $wrappedUser, APIUser $apiUser )
    {
        $this->wrappedUser = $wrappedUser;
        $this->apiUser = $apiUser;
    }

    public function __toString()
    {
        return $this->wrappedUser->getUsername();
    }

    public function isAccountNonExpired()
    {
        return $this->wrappedUser instanceof AdvancedUserInterface ? $this->wrappedUser->isAccountNonExpired() : true;
    }

    public function isAccountNonLocked()
    {
        return $this->wrappedUser instanceof AdvancedUserInterface ? $this->wrappedUser->isAccountNonLocked() : true;
    }

    public function isCredentialsNonExpired()
    {
        return $this->wrappedUser instanceof AdvancedUserInterface ? $this->wrappedUser->isCredentialsNonExpired() : true;
    }

    public function isEnabled()
    {
        return $this->wrappedUser instanceof AdvancedUserInterface ? $this->wrappedUser->isEnabled() : true;
    }

    /**
     * @param \eZ\Publish\API\Repository\Values\User\User $apiUser
     */
    public function setAPIUser( APIUser $apiUser )
    {
        $this->apiUser = $apiUser;
    }

    /**
     * @return \eZ\Publish\API\Repository\Values\User\User
     */
    public function getAPIUser()
    {
        return $this->apiUser;
    }

    public function getRoles()
    {
        return $this->wrappedUser->getRoles();
    }

    public function getPassword()
    {
        return $this->wrappedUser->getPassword();
    }

    public function getSalt()
    {
        return $this->wrappedUser->getSalt();
    }

    public function getUsername()
    {
        return $this->wrappedUser->getUsername();
    }

    public function eraseCredentials()
    {
        $this->wrappedUser->eraseCredentials();
    }

    public function isEqualTo( CoreUserInterface $user )
    {
        return $this->wrappedUser instanceof EquatableInterface ? $this->wrappedUser->isEqualTo( $user ) : true;
    }
}
