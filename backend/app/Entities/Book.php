<?php

namespace App\Entities;

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

    /**
     * Get product weight in KG.
     *
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Set product weight.
     *
     * @param integer $weight
     * @return void
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }

    /**
     * Transform to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
            "weight" => $this->getWeight(),
            ]
        );
    }
}
