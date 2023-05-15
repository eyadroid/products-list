<?php
namespace Entities;

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

    public function setDimensions($heigth, $length, $width)
    {
        $this->heigth = $heigth;
        $this->length = $length;
        $this->width = $width;
    }
    
    public function getHeigth()
    {
        return $this->heigth;
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function getWidth()
    {
        return $this->width;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(), [
            "heigth" => $this->getHeigth(),
            "length" => $this->getLength(),
            "width" => $this->getWidth(),
            ]
        );
    }
}
