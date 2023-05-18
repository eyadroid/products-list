<?php

namespace App\Services;

use App\Entities\Product;

interface ProductServiceInterface
{
    /**
     * Create a product from POST body.
     *
     * @return Product
     */
    public function createProduct(): Product;

    /**
     * Get a product.
     *
     * @param string $sku
     * @return ?Product
     */
    public function getProduct(string $sku): ?Product;

    /**
     * Get all products.
     *
     * @return array
     */
    public function allProducts(): array;

    /**
     * Delete products.
     *
     * @param integer ...$ids
     * @return void
     */
    public function deleteProducts(int ...$ids);
}
