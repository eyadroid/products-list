<?php

namespace App\Entities;

/**
 * @Entity
 */
class Furniture extends Product
{
    /**
     * @Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var                    int
     */
    protected $heigth;
    /**
     * @Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var                    int
     */
    protected $length;
    /**
     * @Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var                    int
     */
    protected $width;

    protected $productType = Product::PRODUCT_TYPE_FURNITURE;

    /**
     * Set product height, length, and width.
     *
     * @param int $heigth
     * @param int $length
     * @param int $width
     * @return void
     */
    public function setDimensions(int $heigth, int $length, int $width)
    {
        $this->heigth = $heigth;
        $this->length = $length;
        $this->width = $width;
    }

    /**
     * Get product height in cm.
     *
     * @return int
     */
    public function getHeigth(): int
    {
        return $this->heigth;
    }

    /**
     * Get product length in cm.
     *
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Get product width in cm.
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
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
            "heigth" => $this->getHeigth(),
            "length" => $this->getLength(),
            "width" => $this->getWidth(),
            ]
        );
    }
}
