<?php 

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;

define('URL', 'http://localhost/projeto-mvc');

View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

include __DIR__ .'/routes/pages.php';

$obRouter->run()
                     ->sendResponse();

//echo "<pre>"; print_r($obRouter); echo "</pre>"; exit;
   

