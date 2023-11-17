<?php

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;

class ProductService
{
    private $productsFile;

    /**
     * @param $productsFile
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->productsFile = $kernel->getProjectDir(). '/public/data/products.json';
    }

    public function getAllProducts(): array {
        return json_decode(file_get_contents($this->productsFile), true);
    }

    public function addProduct(array $product): void {

        $products = $this->getAllProducts();

        $products['data'][] = $product;

        file_put_contents($this->productsFile, json_encode($products));
    }

    public function getProductById(int $id): ?array {

        $products = $this->getAllProducts();
//        dd($products['data']);

        foreach ($products['data'] as $product) {
//            dd($product);
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }




}
