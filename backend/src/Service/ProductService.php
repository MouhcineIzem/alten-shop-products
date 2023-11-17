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


}
