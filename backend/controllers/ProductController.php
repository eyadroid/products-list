<?php 

namespace Controllers;

use Rakit\Validation\Validator;
use Entities\Product;
use Utils\EntityManager;
use Services\ProductService;
use Rules\UniqueRule;

class ProductController
{
    /**
     * @var ProductService
     */
    private $productService;

    function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $this->productService->createProduct();
    }

    public function get()
    {
        // TODO: get single product
    }

    public function store()
    {
        $validator = new Validator;
        $types = array_values(Product::PRODUCT_TYPES);

        $validator->addValidator('unique', new UniqueRule());
        $validation = $validator->validate(
            $_POST, [
            'sku' => 'required|unique:'.Product::class.',sku',
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:'.join(',', $types),
            'weight' => 'required_if:type,book|numeric',
            'size' => 'required_if:type,dvd',
            'height' => 'required_if:type,furniture|numeric',
            'width' => 'required_if:type,furniture|numeric',
            'length' => 'required_if:type,furniture|numeric',
            ]
        );

        if ($validation->fails()) {
            http_response_code(422);
            $errors = $validation->errors();
            return [
                "success" => false,
                "errors" => $errors->toArray()
            ];
        }

        $done = $this->productService->createProduct();

        if (!$done) {
            return [
                "success" => false,
                "message" => "Server error"
            ];
        }

        return [
            "success" => true,
            "message" => "Product created succesfuly"
        ];
    }

    public function bulkDelete()
    {
        // TODO: bulk delete
    }
}
