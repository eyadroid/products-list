<?php
namespace Entities;

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

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(), [
            "size" => $this->getSize(),
            ]
        );
    }
}
