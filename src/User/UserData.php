<?php

declare(strict_types=1);

namespace Otcstores\EventLog\User;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserData implements InterfaceUserData
{
    private const TYPE = 'user';
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getUserId(): string
    {
        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();
        if (null !== $token && $token->isAuthenticated()) {
            $user = $token->getUser();
            if (method_exists($user, 'getId')) {
                return (string)$user->getId();
            }
            if (method_exists($user, 'id')) {
                return (string)$user->id();
            }
            return (string)$token->getUsername();
        }
        return '';
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}