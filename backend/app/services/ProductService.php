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
     * @var EntityManager
     */
    private EntityManager $em;

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
     * Insert a product into database.
     *
     * @return Product
     */
    public function createProduct(): Product
    {
        $type = $_POST['type'];
        $class = $this->getClassFromType($type);
        $instance = $this->createProductInstance($class);
        $extraDataMethod = $this->getSetExtraDataMethodFromType($type);
        $instance = $this->$extraDataMethod($instance);

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
     * @return Product
     */
    public function getProduct(string $sku): Product
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
     * @return Book
     */
    private function setBookExtraData(Book $book): Book
    {
        $weight = $_POST['weight'];
        $book->setWeight($weight);
        return $book;
    }

    /**
     * Set a dvd size from POST body.
     *
     * @param DVD $dvd
     * @return DVD
     */
    private function setDVDExtraData(DVD $dvd): DVD
    {
        $size = $_POST['size'];
        $dvd->setSize($size);
        return $dvd;
    }

    /**
     * Set a furniture height, length, and weight from POST body.
     *
     * @param Furniture $furniture
     * @return Furniture
     */
    private function setFurnitureExtraData(Furniture $furniture): Furniture
    {
        $height = $_POST['height'];
        $length = $_POST['length'];
        $width = $_POST['width'];
        $furniture->setDimensions($height, $length, $width);
        return $furniture;
    }

    /**
     * Create a product with basic data.
     *
     * @param string $class
     * @return Product
     */
    private function createProductInstance(string $class): Product
    {
        $instance = new $class();
        $name = $_POST['name'];
        $price = $_POST['price'];
        $sku = $_POST['sku'];
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
     * @return void
     */
    private function getSetExtraDataMethodFromType(string $type)
    {
        return "set" . ucwords($type) . "ExtraData";
    }
}
