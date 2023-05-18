<?php 

namespace App\Controllers;

use Rakit\Validation\Validator;
use App\Entities\Product;
use App\Utils\EntityManager;
use App\Services\ProductService;
use App\Rules\UniqueRule;

class ProductController extends Controller
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
        $products = $this->productService->allProducts();

        foreach ($products as $key => $product) {
            $products[$key] = $product->toArray();
        }

        return $this->responseDataWithETag($products);
    }

    public function show()
    {
        $validator = new Validator;
        $validation = $validator->make(
            $_GET, [
                'sku' => ['required', 'regex:/^[0-9A-Za-z]++$/']
            ]
        );

        if ($validation->fails()) {
            http_response_code(404);
            return;
        }

        $product = $this->productService->getProduct($_GET['sku']);

        if (!$product) {
            http_response_code(404);
            return [
                "message" => "Product not found."
            ];
        }

        $response = $product->toArray();
        return $this->responseDataWithETag($response);
    }

    public function store()
    {
        $_POST = json_decode(file_get_contents("php://input"), true);

        $validator = new Validator;
        $types = array_values(Product::PRODUCT_TYPES);

        $validator->addValidator('unique', new UniqueRule());
        $validation = $validator->validate(
            $_POST, [
            'sku' => ['required', 'regex:/^[0-9A-Za-z]++$/', 'unique:'.Product::class.',sku'],
            'name' => 'required',
            'price' => 'required|numeric|min:0|not_in:0',
            'type' => 'required|in:'.join(',', $types),
            'weight' => 'required_if:type,book|numeric|min:0|not_in:0',
            'size' => 'required_if:type,dvd',
            'height' => 'required_if:type,furniture|numeric|min:0|not_in:0',
            'width' => 'required_if:type,furniture|numeric|min:0|not_in:0',
            'length' => 'required_if:type,furniture|numeric|min:0|not_in:0',
            ]
        );

        if ($validation->fails()) {
            http_response_code(422);
            $errors = $validation->errors();
            return [
                "errors" => $errors->toArray()
            ];
        }

        $product = $this->productService->createProduct();

        if (!$product) {
            http_response_code(500);
            return [
                "message" => "Server error"
            ];
        }

        return [
            "message" => "Product created succesfuly",
            "data" => $product->toArray()
        ];
    }

    public function bulkDelete()
    {
        $_GET = json_decode(file_get_contents("php://input"), true);

        $validator = new Validator;
        $validation = $validator->make(
            $_GET, [
            'ids' => 'array',
            'ids.*' => 'required|numeric',
            ]
        );

        if ($validation->fails()) {
            http_response_code(422);
            $errors = $validation->errors();
            return [
                "errors" => $errors->toArray()
            ];
        }

        $this->productService->deleteProducts($_GET['ids']);

        return [
            "message" => "Products deleted successfully."
        ];
    }
}
