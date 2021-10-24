<?php

use \App\Http\Response;
use \App\Controller\Pages;


//rota Home
$obRouter->get('/', [
    function (){
        return new Response(200, Pages\Home::getHome());
    }
]);

//rota Sobre
$obRouter->get('/sobre', [
    function (){
        return new Response(200, Pages\About::getAbout());
    }
]);

//rota Dinâmica
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao){
        return new Response(200, 'Pagina '.$idPagina . ' - ' . $acao);
    }
]);