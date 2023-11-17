<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $productService;

    /**
     * @param $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/api/products', name:'api_products')]
    public function getAllProducts() {

        $jsonFilePath = $this->getParameter('kernel.project_dir').'/public/data/products.json';

        if (!file_exists($jsonFilePath)) {
            throw new FileNotFoundException('The JSON file does not exist');
        }

        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        return new JsonResponse($data);
    }

    #[Route('/api/product', methods: ['POST'])]
    public function addProduct(Request $request) {

        $data = json_decode($request->getContent(), true);

        dd($data);

        $this->productService->addProduct($data);

        return $this->json(['message' => 'Product added successfully.']);
    }


    #[Route('/api/products/{id}', methods: ['GET'])]
    public function getProductById(int $id): Response {
        $product = $this->productService->getProductById($id);

        if ($product === null) {
            return $this->json(['error' => 'Product not found.'], 404);
        }
        return $this->json($product);
    }

    


}
