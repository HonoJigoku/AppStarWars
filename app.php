<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DEGUG', true);
/* ------------------------------------------------- *\
    Request
\* ------------------------------------------------- */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtolower($_SERVER["REQUEST_METHOD"]);


/* ------------------------------------------------- *\
    Helpers
\* ------------------------------------------------- */

function view($path, array $data, $status='200 Ok')
{
    $fileName = __DIR__.'/resources/views/'. str_replace('.', '/', $path). '.php';

    if(!file_exists($fileName)) die(sprintf('this view doesn\'t exists %S', $fileName));

    header("HTTP/1.1 $status");
    header('Content-type: text/html; charset=UTF-8');

    extract($data);
    include $fileName;

}

function url($path='',$params='')
{
    if(!empty($params)) $params = "/$params";
    return 'http://localhost:8000/'.$path.$params;
}

/* ------------------------------------------------- *\
    Connect Database
\* ------------------------------------------------- */

\Connect::set([
    'dsn' => 'mysql:host=localhost;dbname=db_starwars',
    'username' => 'root',
    'password' => ''
]);

//var_dump(\Connect::$pdo);


/* ------------------------------------------------- *\
    Controllers
\* ------------------------------------------------- */

use Controllers\FrontController;

/* ------------------------------------------------- *\
    Router
\* ------------------------------------------------- */

if($method=='get')
{
    switch($uri)
    {
        case "/":

            //echo "page d'accueil";

           $frontController = new Controllers\FrontController;
           $frontController->index();

           break;


        // /casque/1 ou laser/2 ou laser/1 ...
        case preg_match('/\/product\/([1-9][0-9]*)/', $uri, $m) == 1:

            $frontController = new Controllers\FrontController();
            $frontController->show($m[1]);

            break;

        case "/cart":

            $frontController = new Controllers\FrontController();
            $frontController->showCart();
            break;

        default:
            $message = 'Not Found !';
            view('front.404', compact('message'), '404 Not Found');

    }
}

if($method=='post'){
    switch($uri){
        case '/command' :

            $frontController = new FrontController();
            $frontController->command();


            break;

        case '/store' :

            $frontController = new FrontController();
            $frontController->store();


            break;
    }
}