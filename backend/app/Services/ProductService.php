<?php

namespace App\Services;

use App\Entities\Product;
use App\DB\EntityManager;
use App\Factories\BookFactory;
use App\Factories\DVDFactory;
use App\Factories\FurnitureFactory;

class ProductService implements ProductServiceInterface
{
    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private \Doctrine\ORM\EntityManager $em;

    /**
     * A map of product type to it's corresponding factory.
     */
    protected const TYPE_TO_FACTORY = [
        'book' => BookFactory::class,
        'dvd' => DVDFactory::class,
        'furniture' => FurnitureFactory::class,
    ];

    public function __construct()
    {
        $this->em = EntityManager::getInstance();
    }

        /**
     * Create a product.
     *
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @param string $type
     * @param integer|null $weight
     * @param integer|null $size
     * @param integer|null $height
     * @param integer|null $length
     * @param integer|null $width
     * @return Product
     */
    public function createProduct(
        string $name,
        int $price,
        string $sku,
        string $type,
        ?int $weight,
        ?int $size,
        ?int $height,
        ?int $length,
        ?int $width
    ): ?Product {
        // create product factory based on type
        $factoryClass = $this->getFactoryFromType($type);
        $factory = new $factoryClass();
        if ($factory instanceof BookFactory || $factory instanceof DVDFactory || $factory instanceof FurnitureFactory) {
            $instance = $factory->create(
                $name,
                $price,
                $sku,
                $type,
                [
                    'weight' => $weight,
                    'size' => $size,
                    'height' => $height,
                    'length' => $length,
                    'width' => $width,
                ]
            );
            // Saving product to database
            $this->em->getConnection()->beginTransaction(); // suspend auto-commit
            try {
                $this->em->persist($instance);
                $this->em->flush();
                $this->em->getConnection()->commit();
                return $instance;
            } catch (\Exception $e) {
                $this->em->getConnection()->rollback();
                return null;
            }
        }
    }

    /**
     * Get a product from database.
     *
     * @param string $sku
     * @return ?Product
     */
    public function getProduct(string $sku): ?Product
    {
        $product = $this->em->getRepository(Product::class)
            ->findOneBy(['sku' => $sku]);
        return $product;
    }

    /**
     * Get all products from database.
     *
     * @return array
     */
    public function allProducts(): array
    {
        $products = $this->em->getRepository(Product::class)
            ->findBy([], ['id' => 'DESC']);
        return $products;
    }

    /**
     * Delete products from database.
     *
     * @param integer ...$ids
     * @return void
     */
    public function deleteProducts(int ...$ids)
    {
        $this->em->createQueryBuilder()
            ->delete(Product::class, 'p')
            ->where('p.id in (:ids)')
            ->setParameter('ids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->execute();
    }

    /**
     * Get a product factory from type.
     *
     * @param string $type
     * @return string
     */
    private function getFactoryFromType(string $type): string
    {
        return self::TYPE_TO_FACTORY[$type];
    }
}
