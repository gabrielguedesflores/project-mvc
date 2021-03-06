<?php

namespace App\Controller\Pages;

use \App\Utils\View; 
use \App\Model\Entity\Organization;

class Home extends Page
{
        
    /**
     * Retorna o conteúdo (view) da home
     *
     * @return string
     */
    public static function getHome(){
        $obOrganization = new Organization();
        $content = View::render('pages/home', [
            'name'            => $obOrganization->name
        ]);

        return parent::getPage('Gabs - Projeto MVC', $content); //retorna a view da pagina, passando os parâmetros esperados em page
    }


}
