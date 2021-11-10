<?php

namespace App\Http;

class Request
{
    
    /**
     * Método HTTP da requisição
     *
     * @var string
     */
    private $httpMethod;
    
    /**
     * URI da página
     *
     * @var string
     */
    private $uri;
    
    /**
     * Parâmetros da URL ($_GET)
     *
     * @var array
     */
    private $queryParams = [];
    
    /**
     * Variáveis que vamos receber no POST 
     *
     * @var array
     */
    private $postVars = [];
    
    /**
     * Headers da requisição
     *
     * @var array
     */
    private $headers = [];
    /**
     * ?? <- se não existir passa o valor vazio
     */
    public function __construct(){
        $this->queryParams = $_GET ?? [];
        $this->postVars         = $_POST ?? [];
        $this->headers           = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri                      = $_SERVER['REQUEST_URI'] ?? '';
    }
    
    /**
     * retorna o método HTTP da requisição
     *
     * @return string
     */
    public function getHttpMethod(){
        return $this->httpMethod;
    }

     /**
     * retorna o método a URI da requisição
     *
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }

    /**
     * retorna os headers da requisição
     *
     * @return array
     */
    public function getHeaders(){
        return $this->headers;
    }

     /**
     * retorna os parâmetros da URL da requisição
     *
     * @return array
     */
    public function getQueryParams(){
        return $this->queryParams;
    }

    /**
     * retorna as variáveis POST da requisição
     *
     * @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }

}