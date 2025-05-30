<?php

namespace App\Controller;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class MediaObjectController extends AbstractController
{

    public function __invoke(Request $request, EntityManagerInterface $em): JsonResponse
    {

        $uploadedFile = $request->files->get('file');

        // Rend le champ obligatoire
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $media = new MediaObject();
        $media->file = $uploadedFile;
        $media->setName($request->get('title'));

        $em->persist($media);
        $em->flush();

        return new JsonResponse([
            'status' => 'success',
            'media' => [
                'id' => $media->getId(),
            ]
        ], 201);
    }
}
