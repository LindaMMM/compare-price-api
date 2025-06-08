<?php

namespace App\Security\Voter;

use App\Security\RoleEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

final class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';
    public const VIEW = 'PRODUCT_VIEW';
    public const DELETE = 'PRODUCT_DELETE';

    public function __construct(private AccessDecisionManagerInterface $accessDecisionManager,) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if ($this->accessDecisionManager->decide($token, [RoleEnum::USER])) {
                    return true;
                }
                break;

            case self::VIEW:
                if ($this->accessDecisionManager->decide($token, [RoleEnum::USER])) {
                    return true;
                }
                break;
            case self::DELETE:
                if ($this->accessDecisionManager->decide($token, [RoleEnum::ADMIN])) {
                    return true;
                }
                break;
        }

        return false;
    }
}
