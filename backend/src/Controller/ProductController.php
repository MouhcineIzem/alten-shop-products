<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
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


}
