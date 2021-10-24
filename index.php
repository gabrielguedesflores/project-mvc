<?php 

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages\Home;

define('URL', 'http://localhost/projeto-mvc');

$obRouter = new Router(URL);

//rota Home
$obRouter->get('/', [
    function (){
        return new Response(200, Home::getHome());
    }
]);

$obRouter->run()
                     ->sendResponse();

//echo "<pre>"; print_r($obRouter); echo "</pre>"; exit;
   

