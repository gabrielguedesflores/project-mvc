<?php

namespace App\Controller\Pages;

use \App\Utils\View; 
use \App\Model\Entity\Organization;
use \App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{
            
    /**
     * Obtem a renderização dos itens de depoiumentos para a página
     *
     * @return string
     */
    private static function getTestimonyItems(){
        return $itens;
    }
    
    /**
     * Retorna o conteúdo (view) de depoimentos
     *
     * @return string
     */
    public static function getTestimonies(){
        
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems()
        ]);

        return parent::getPage('Depoimentos - Projeto MVC', $content); //retorna a view da pagina, passando os parâmetros esperados em page
    }
    
    /**
     * Responsábvel por cadastrar o depoimento
     *
     * @param  Request $request
     * @return string
     */
    public static function insertTestimony($request){
        $postVars = $request->getPostVars();
        $obTestimony = new EntityTestimony;
        //fazer uma validação para garantir que os dadas chegaram
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();
        return self::getTestimonies();
    }

}
//echo "<pre>"; print_r($postVars); echo "</pre>"; exit;