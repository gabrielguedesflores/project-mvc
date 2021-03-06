<?php

namespace App\Utils;

class View
{
    /**
     * Váriaveis padrões do View 
     *  @var array
     */        
    private static $vars = [];

    /**
     * Defini os dados iniciais da classe
     *
     * @param  array $vars
     */
    public static function init($vars = []){
        self::$vars = $vars;
    }
    /**
     * retorna conteúdo da view
     *
     * @param  string $view
     * @return string
     */
    private static function getContentView($view){
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Retorna o conteúdo renderizado da view
     *
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = []){
        $contentView = self::getContentView($view);
        $vars = array_merge(self::$vars, $vars); //merge de váriaveis da view
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{' . $item . '}}';
        }, $keys); //mapeia as variáveis {{ }} que temos nas view e no return fazemos a substituição 

        //echo "<pre>"; print_r($keys); echo "</pre>"; exit;
        return str_replace($keys, array_values($vars), $contentView);
    }
    
}
//echo "<pre>"; print_r($vars); echo "</pre>"; exit;