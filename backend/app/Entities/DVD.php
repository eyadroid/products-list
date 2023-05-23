<?php

namespace App\Entities;

/**
 * @Entity
 */
class DVD extends Product
{
    /**
     * @Column(type="integer", nullable=true)
     * @var                    int
     */
    protected $size;
    // on Init set data
    protected $productType = Product::PRODUCT_TYPE_DVD;

    /**
     * Get product size in bytes.
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set product size.
     *
     * @param int $size
     * @return void
     */
    public function setSize(int $size)
    {
        $this->size = $size;
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
            "size" => $this->getSize(),
            ]
        );
    }
}
