<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
//...
final class SecurityController extends AbstractController
{
    #[Route('/auth/token/invalidate', name: 'auth', methods: ['POST'])]
    public function logout(Request $request, EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage)
    {
        $eventDispatcher->dispatch(new LogoutEvent($request, $tokenStorage->getToken()));

        return new JsonResponse();
    }

    /*#[Route('/auth', name: 'auth', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }*/

    /*  #[Route('/api/mename', name: 'app_me', methods: ['GET'])]
    public function me()
    {

        return $this->json([
            'me' => "hello"
        ]);
    }

    #[Route('/api/mename', name: 'app_me', methods: ['GET'])]
    public function me()
    {

        return $this->json([
            'me' => "hello"
        ]);
    }*/
}
