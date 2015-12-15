<?php namespace Controllers;

use Cart\StorageSession;
use Models\History;
use Models\Customer;
use Models\Model;
use Models\Product;
use Models\Tag;
use Models\Image;
use Cart\Cart;
use Cart\SessionStorage;

class FrontController
{

    public function __construct()
    {
        $this->cart = new Cart(new StorageSession('starwars'));
    }

    public function index()
    {

        $product = new Product();

        $products = $product->all();

        $image = new Image;

        $tag = new Tag;

        var_dump($this->cart->all());

        view('front.index', compact('products', 'image', 'tag'));

    }

    public function show($id)
    {
        $productModel = new Product();

        $product = $productModel->find($id);

        $image = new Image;

        $tag = new Tag;

        view('front.single', compact('product', 'image', 'tag'));
    }

    public function showCart()
    {
        /*$_SESSION['starwars'];*/

        var_dump($this->cart->all());
        $storage = $this->cart->all();

        $products = [];

        foreach ($storage as $id => $total) {
            $p = new Product();
            $stmt = $p->find($id);

            $products[$stmt->title]['price'] = (float)$stmt->price;
            $products[$stmt->title]['total'] = $total;
            $products[$stmt->title]['quantity'] = $total / $stmt->price; // todo price = 0
            $products[$stmt->title]['product_id'] = $id;

            $image = new Image;

            view('front.cart', compact('products', 'image'));
        }
    }

    public function command()
    {

        $rules = [
            'id' => FILTER_VALIDATE_INT,
            'price' => FILTER_VALIDATE_FLOAT,
            'name' => FILTER_SANITIZE_STRING,
            'quantity' => FILTER_VALIDATE_INT
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);

        //var_dump($sanitize);

        $productCart = new \Cart\Product($sanitize['name'], $sanitize['price']);

        $this->cart->buy($productCart, $sanitize['quantity']);

        $this->redirect(url());

    }

    public function store()
    {
        if (empty($_SESSION)) session_start();

        (empty($_SESSION['old'])) ?: $_SESSION['old'] = [];
        (empty($_SESSION['error'])) ?: $_SESSION['error'] = [];

        $rules = [
            'email' => FILTER_VALIDATE_EMAIL,
            'number' => [
                'filter' => FILTER_CALLBACK,
                'options' => function ($nb) {
                    if (preg_match('/[0-9]{16}/', $nb)) return (int)$nb;
                    return false;
                }
            ],

            'address' => FILTER_SANITIZE_STRING
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);

        var_dump($sanitize);

        $error = false;

        if (!$sanitize['email']) {
            $error = true;
            $_SESSION['error']['email'] = "Email Invalid";
        }
        if (!$sanitize['number']) {
            $error = true;
            $_SESSION['error']['number'] = "Blue Card number Invalid";
        }
        if (!$sanitize['address']) {
            $error = true;
            $_SESSION['error']['address'] = "You must give your address";
        }

        if ($error) {

            $_SESSION['old']['email'] = $sanitize['email'];
            $_SESSION['old']['address'] = $sanitize['address'];

            $this->redirect(url('cart'));
        }

        try {

            \Connect::$pdo->beginTransaction();

            $history = new History();

            $customer = new Customer();

            $customer->create(['email' => $sanitize['email'], 'number' => $sanitize['number'], 'addess' => $sanitize['address']]);

            $customerId = \Connect::$pdo->LastInsertID;

            $storage = $this->cart->all();

            $products = [];

            foreach ($storage as $id => $total) {
                $p = new Product();
                $stmt = $p->find($id);

                $history->create([
                    'product_id' => $id,
                    'price' => (float) $stmt->price,
                    'total' => $total,
                    'quantity' => $total/$stmt->price,
                    'commandet_at' => date('Y-m-d h:i:s')
                ]);

                $this->cart->reset();

                $this->redirect(url());

            }

            \Connect::$pdo->commit();

        } catch (\PDOException $e) {

            \Connect::$pdo->rollback();

        }
    }

    private function redirect($path, $status = '200 Ok')
    {
        header("HTTP/1.1 $status");
        header('Content-Type: html/text charset=UTF-8');
        header("Location: $path");
        exit;
    }
}