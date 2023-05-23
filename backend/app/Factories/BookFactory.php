<?php

namespace App\Factories;

use App\Entities\Book;

class BookFactory extends ProductFactory
{
    /**
     * Create a book.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @param array $extraData
     * @return Book
     */
    public function create(string $name, int $price, string $sku, string $type, array $extraData): Book
    {
        parent::initialize($name, $price, $sku, $type);

        if ($this->instance instanceof Book) {
            $this->instance->setWeight($extraData['weight']);
            return $this->instance;
        } else {
            throw new \Exception("Product type must be a book.");
        }
    }
}
