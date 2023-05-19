<?php

namespace App\Services;

use App\Entities\Product;
use App\Entities\Book;
use App\Entities\DVD;
use App\Entities\Furniture;
use App\DB\EntityManager;

class ProductService implements ProductServiceInterface
{
    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private \Doctrine\ORM\EntityManager $em;

    /**
     * A map of product type to it's corresponding class.
     */
    protected const TYPE_TO_CLASS = [
        'book' => Book::class,
        'dvd' => DVD::class,
        'furniture' => Furniture::class,
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
        // get the product type class and create an instance
        // with basic data
        $class = $this->getClassFromType($type);
        $instance = $this->createProductInstance($class, $name, $price, $sku);

        // get the product set additional method and call it
        $extraDataMethod = $this->getSetExtraDataMethodFromType($type);
        $instance = $this->$extraDataMethod($instance, [
            'weight' => $weight,
            'size' => $size,
            'height' => $height,
            'length' => $length,
            'width' => $width,
        ]);

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
     * Set a book weight from POST body.
     *
     * @param Book $book
     * @param array $data
     * @return Book
     */
    private function setBookExtraData(Book $book, array $data): Book
    {
        $weight = $data['weight'];
        $book->setWeight($weight);
        return $book;
    }

    /**
     * Set a dvd size from POST body.
     *
     * @param DVD $dvd
     * @param array $data
     * @return DVD
     */
    private function setDVDExtraData(DVD $dvd, array $data): DVD
    {
        $size = $data['size'];
        $dvd->setSize($size);
        return $dvd;
    }

    /**
     * Set a furniture height, length, and weight from POST body.
     *
     * @param Furniture $furniture
     * @param array $data
     * @return Furniture
     */
    private function setFurnitureExtraData(Furniture $furniture, array $data): Furniture
    {
        $height = $data['height'];
        $length = $data['length'];
        $width = $data['width'];
        $furniture->setDimensions($height, $length, $width);
        return $furniture;
    }

    /**
     * Create a product with basic data.
     *
     * @param string $class
     * @param string $name
     * @param integer $price
     * @param string $sku
     * @return Product
     */
    private function createProductInstance(string $class, string $name, int $price, string $sku): Product
    {
        $instance = new $class();
        $instance->setBasicData($name, $price, $sku);
        return $instance;
    }

    /**
     * Get a product class from type.
     *
     * @param string $type
     * @return string
     */
    private function getClassFromType(string $type): string
    {
        return self::TYPE_TO_CLASS[$type];
    }

    /**
     * Get the extra data method of a type.
     *
     * @param string $type
     * @return string
     */
    private function getSetExtraDataMethodFromType(string $type): string
    {
        return "set" . ucwords($type) . "ExtraData";
    }
}
