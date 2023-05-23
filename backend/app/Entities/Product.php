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

    public const PRODUCT_TYPE_BOOK = 1;
    public const PRODUCT_TYPE_DVD = 2;
    public const PRODUCT_TYPE_FURNITURE = 3;

    public const PRODUCT_TYPES = [
        self::PRODUCT_TYPE_BOOK => "book",
        self::PRODUCT_TYPE_DVD => "dvd",
        self::PRODUCT_TYPE_FURNITURE => "furniture",
    ];

    /**
     * Get product ID.
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get product price.
     *
     * @return integer
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Get product SKU.
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * Get product type.
     *
     * @return string
     */
    public function getType(): string
    {
        return self::PRODUCT_TYPES[$this->productType];
    }

    /**
     * Set product name, price, and SKU.
     *
     * @return void
     */
    public function setBasicData(string $name, int $price, string $sku)
    {
        $this->name = $name;
        $this->price = $price;
        $this->sku = $sku;
    }

    /**
     * Transform to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "sku" => $this->getSku(),
            "price" => $this->getPrice(),
            "type" => $this->getType(),
        ];
    }
}
