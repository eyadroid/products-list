<?php

namespace Services;

use Entities\Product;
use Entities\Book;
use Entities\DVD;
use Entities\Furniture;
use Utils\EntityManager;

class ProductService {
    const TYPE_TO_CLASS = [
        'book' => Book::class,
        'dvd' => DVD::class,
        'furniture' => Furniture::class,
    ];

    public function createProduct() {
        $type = $_POST['type'];
        $class = $this->getClassFromType($type);
        $instance = $this->createProductInstance($class);
        $extraDataMethod = $this->getSetExtraDataMethodFromType($type);
        $instance = $this->$extraDataMethod($instance);

        $entityManager = EntityManager::getInstance();
        $entityManager->persist($instance);
        $entityManager->flush();
    }

    private function setBookExtraData($book) {
        $weight = $_POST['weight'];
        $book->setWeight($weight);
        return $book;
    }

    private function setDVDExtraData($dvd) {
        $size = $_POST['size'];
        $dvd->setSize($size);
        return $dvd;
    }

    private function setFurnitureExtraData($furniture) {
        $height = $_POST['height'];
        $length = $_POST['length'];
        $width = $_POST['width'];
        $furniture->setDimensions($height, $length, $width);
        return $furniture;
    }

    private function createProductInstance($class) {
        $instance = new $class;
        $name = $_POST['name'];
        $price = $_POST['price'];
        $sku = $_POST['sku'];
        $instance->setBasicData($name, $price, $sku);
        return $instance;
    }

    private function getClassFromType($type) {
        return self::TYPE_TO_CLASS[$type];
    }

    private function getSetExtraDataMethodFromType($type) {
        return "set".ucwords($type)."ExtraData";
    }
}