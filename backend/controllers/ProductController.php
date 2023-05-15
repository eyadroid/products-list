<?php 

namespace Controllers;

use Rakit\Validation\Validator;
use Entities\Product;
use Utils\EntityManager;
use Services\ProductService;

class ProductController
{
    /**
     * @var ProductService
     */
    private $productService;

    function __construct() {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $this->productService->createProduct();
    }

    public function store() {
        // TODO: validation
        // $validator = new Validator;

        // $validation = $validator->validate($_POST, [
        //     $type => 'required',
        // ]);

        $this->productService->createProduct();
    }

    public function bulkDelete() {
        // TODO: bulk delete
    }
}
