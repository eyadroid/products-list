<?php

namespace App\Services;

use App\Entities\Product;
use App\Entities\Book;
use App\Entities\DVD;
use App\Entities\Furniture;
use App\DB\EntityManager;

class ProductService
{
    private $em;

    protected const TYPE_TO_CLASS = [
        'book' => Book::class,
        'dvd' => DVD::class,
        'furniture' => Furniture::class,
    ];

    public function __construct()
    {
        $this->em = EntityManager::getInstance();
    }

    public function createProduct()
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
        } catch (Exception $e) {
            $this->em->getConnection()->rollback();
            return null;
        }
    }

    public function getProduct($sku)
    {
        $product = $this->em->getRepository(Product::class)
            ->findOneBy(['sku' => $sku]);
        return $product;
    }

    public function allProducts()
    {
        $products = $this->em->getRepository(Product::class)
            ->findBy([], ['id' => 'DESC']);
        return $products;
    }

    public function deleteProducts($ids)
    {
        $this->em->createQueryBuilder()
            ->delete(Product::class, 'p')
            ->where('p.id in (:ids)')
            ->setParameter('ids', $ids, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
            ->getQuery()
            ->execute();
    }

    private function setBookExtraData($book)
    {
        $weight = $_POST['weight'];
        $book->setWeight($weight);
        return $book;
    }

    private function setDVDExtraData($dvd)
    {
        $size = $_POST['size'];
        $dvd->setSize($size);
        return $dvd;
    }

    private function setFurnitureExtraData($furniture)
    {
        $height = $_POST['height'];
        $length = $_POST['length'];
        $width = $_POST['width'];
        $furniture->setDimensions($height, $length, $width);
        return $furniture;
    }

    private function createProductInstance($class)
    {
        $instance = new $class();
        $name = $_POST['name'];
        $price = $_POST['price'];
        $sku = $_POST['sku'];
        $instance->setBasicData($name, $price, $sku);
        return $instance;
    }

    private function getClassFromType($type)
    {
        return self::TYPE_TO_CLASS[$type];
    }

    private function getSetExtraDataMethodFromType($type)
    {
        return "set" . ucwords($type) . "ExtraData";
    }
}
