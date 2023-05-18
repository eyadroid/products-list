<?php

namespace App\Entities;

/**
 * @Entity
 * @Table("products")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="productType", type="integer")
 * @DiscriminatorMap({1                     = "Book", 2 = "DVD", 3 = "Furniture"})
 */

abstract class Product
{
    /**
     * @Id  @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var                   string
     */
    protected $name;
    /**
     * @Column(type="decimal", precision=13, scale=2)
     * @var                    float
     */
    protected $price;
    /**
     * @Column(type="string", unique=true)
     * @var                   int
     */
    protected $sku;

    const PRODUCT_TYPE_BOOK = 1;
    const PRODUCT_TYPE_DVD = 2;
    const PRODUCT_TYPE_FURNITURE = 3;

    const PRODUCT_TYPES = [
        self::PRODUCT_TYPE_BOOK => "book",
        self::PRODUCT_TYPE_DVD => "dvd",
        self::PRODUCT_TYPE_FURNITURE => "furniture",
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getType()
    {
        return self::PRODUCT_TYPES[$this->productType];
    }

    public function setBasicData($name, $price, $sku)
    {
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
    }

    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "sku" => $this->getSku(),
            "price" => $this->getPrice(),
            "type" => $this->getType(),
            "weight" => null,
            "length" => null,
            "width" => null,
            "height" => null,
        ];
    }
}
