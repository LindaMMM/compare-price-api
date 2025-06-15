<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\StatementRepository;
use App\Entity\Product;
use App\Entity\Statement;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

#[AsController]
final class GetLastStatementController extends AbstractController
{
    public function __construct(private StatementRepository $statementRepository) {}
    public function __invoke(Request $request): JsonResponse
    {
        $productId = $request->get('productId');
        if (!$productId) {
            return new JsonResponse(['error' => 'Product ID is required'], 400);
        }
        $statement =  $this->statementRepository->getLast($productId);
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($statement, 'json');
        return new JsonResponse($json);
    }
}
