<?php

namespace App\Factories;

use App\Entities\Product;
use App\Entities\Book;
use App\Entities\DVD;
use App\Entities\Furniture;

abstract class ProductFactory
{
    /**
     * Product created instance.
     *
     * @var Product
     */
    protected $instance;

    /**
     * A map of product type to it's corresponding class.
     */
    protected const TYPE_TO_CLASS = [
        'book' => Book::class,
        'dvd' => DVD::class,
        'furniture' => Furniture::class,
    ];

    /**
     * Initialize product instance based on it's type.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @return Product
     */
    public function initialize(string $name, int $price, string $sku, string $type): Product
    {
        // get the product type class and create an instance
        // with basic data
        $class = $this->getClassFromType($type);
        try {
            $this->instance = new $class();
            $this->instance->setBasicData($name, $price, $sku);
            return $this->instance;
        } catch (\Exception $e) {
            throw new \Exception("Product type not found");
        }
    }

    /**
     * Get a product class from type.
     *
     * @param string $type
     * @return string
     */
    private function getClassFromType(string $type): string
    {
        return self::TYPE_TO_CLASS[$type];
    }
}
