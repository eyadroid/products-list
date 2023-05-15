<?php
namespace Entities;

/**
 * @Entity
 */
class Book extends Product
{
    /**
     * @Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var                    int
     */
    protected $weight;
    protected $productType = Product::PRODUCT_TYPE_BOOK;

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
