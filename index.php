<?php 

require __DIR__ . '/vendor/autoload.php';

use \App\Controller\Pages\Home;



//-echo "<pre>"; print_r($obResponse); echo "</pre>"; exit;

echo Home::getHome();

