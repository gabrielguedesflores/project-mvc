<?php

namespace App\Controller\Pages;

use \App\Utils\View; 

class Page
{
        
    /**
     * Renderiza o topo da página
     *
     * @return string
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

    /**
     * Renderiza o rodapé da página
     *
     * @return string
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }

    /**
     * Retorna o conteúdo (view) da página genérica
     *
     * @return string
     */
    public static function getPage($title, $content){

        return View::render('pages/page', [
            'title'        => $title,
            'header'  => self::getHeader(), 
            'content' => $content,
            'footer'    => self::getFooter(), 

        ]);
    }

}
