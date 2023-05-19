<?php

namespace App\Services;

use App\Entities\Product;

interface ProductServiceInterface
{
    /**
     * Create a product.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @param integer|null $weight
     * @param integer|null $size
     * @param integer|null $heigth
     * @param integer|null $length
     * @param integer|null $width
     * @return Product
     */
    public function createProduct(
        string $name,
        int $price,
        string $sku,
        string $type,
        ?int $weight,
        ?int $size,
        ?int $heigth,
        ?int $length,
        ?int $width
    ): ?Product;

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
