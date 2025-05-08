<?php

namespace App\Context;

use ApiPlatform\State\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;

class RoleContextBuilder implements SerializerContextBuilderInterface
{
    public function __construct(
        private SerializerContextBuilderInterface $decorated,
        private AuthorizationCheckerInterface  $authorizationChecker
    ) {}

    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

        if (!$normalization && $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $context['groups'][] = 'admin:write';
        }

        return $context;
    }
}
