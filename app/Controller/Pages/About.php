<?php

namespace App\Controller\Pages;

use \App\Utils\View; 
use \App\Model\Entity\Organization;

class About extends Page
{
        
    /**
     * Retorna o conteúdo (view) da sobre
     *
     * @return string
     */
    public static function getAbout(){
        $obOrganization = new Organization();
        $content = View::render('pages/about', [
            'name'            => $obOrganization->name,
            'description' => $obOrganization->description,
            'site'                => $obOrganization->site
        ]);

        //retorna a view da página
        return parent::getPage('Sobre - Projeto MVC', $content); //retorna a view da pagina, passando os parâmetros esperados em page
    }


}
