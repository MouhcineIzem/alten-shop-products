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

    public function updateProduct(int $id, array $updatedProduct): bool {

        $products = $this->getAllProducts();

//        dd($products);

        $index = array_search($id, array_column($products['data'], 'id'));
//        dd($index);


        if ($index === false) return false;

        $products['data'][$index] = array_merge($products['data'][$index], $updatedProduct);

        file_put_contents($this->productsFile, json_encode($products));

        return true;
    }

    public function deleteProduct(int $id): bool {

        $products = $this->getAllProducts();

        $index = array_search($id, array_column($products['data'], 'id'));

        if ($index === false) return false;
        
        array_splice($products['data'], $index, 1);

        file_put_contents($this->productsFile, json_encode($products));

        return true;
    }

}
