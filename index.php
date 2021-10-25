<?php 

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;

Environment::load(__DIR__);

//define a constant da URL
define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

include __DIR__ .'/routes/pages.php';

$obRouter->run()
                     ->sendResponse();

//echo "<pre>"; print_r($obRouter); echo "</pre>"; exit;
   

