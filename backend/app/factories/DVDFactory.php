<?php

namespace App\Factories;

use App\Entities\DVD;

class DVDFactory extends ProductFactory
{
    /**
     * Create a DVD.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @param array $extraData
     * @return DVD
     */
    public function create(string $name, int $price, string $sku, string $type, array $extraData): DVD
    {
        parent::initialize($name, $price, $sku, $type);

        if ($this->instance instanceof DVD) {
            $this->instance->setSize($extraData['size']);
            return $this->instance;
        } else {
            throw new \Exception("Product type must be a dvd.");
        }
    }
}
