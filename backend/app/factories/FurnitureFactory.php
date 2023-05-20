<?php

namespace App\Factories;

use App\Entities\Furniture;

class FurnitureFactory extends ProductFactory
{
    /**
     * Create a Furniture.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @param array $extraData
     * @return Furniture
     */
    public function create(string $name, int $price, string $sku, string $type, array $extraData): Furniture
    {
        parent::initialize($name, $price, $sku, $type);

        if ($this->instance instanceof Furniture) {
            $this->instance->setDimensions($extraData['height'], $extraData['length'], $extraData['width']);
            return $this->instance;
        } else {
            throw new \Exception("Product type must be a furniture.");
        }
    }
}
