<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\StatementRepository;
use App\Entity\Product;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;

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

        return new JsonResponse([
            $this->statementRepository->getLast($productId)
        ]);
    }
}
