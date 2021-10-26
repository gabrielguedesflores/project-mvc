<?php

namespace App\Controller\Pages;

use \App\Utils\View; 
use \App\Model\Entity\Organization;

class Testimony extends Page
{
        
    /**
     * Retorna o conteúdo (view) de depoimentos
     *
     * @return string
     */
    public static function getTestimonies(){
        
        $content = View::render('pages/testimonies', [
            
        ]);

        return parent::getPage('Depoimentos - Projeto MVC', $content); //retorna a view da pagina, passando os parâmetros esperados em page
    }


}
