<?php 

namespace App\Http;

use \Closure;
use \Exception;

class Router
{
    
    /**
     * URL completa do projeto (a raiz)
     *
     * @var string
     */
    private $url = '';

        
    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';
    
    /**
     * Índice de rotas
     *
     * @var array
     */
    private $routes = [];
    
    /**
     * Uma instância de request
     *
     * @var request
     */
    private $request;
    
    /**
     * __construct
     *
     * @param  string $url
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url = $url; 
        $this->setPrefix();
    }
    
    /**
     * Responsável por definir o prefixo das rotas
     *
     */
    private function setPrefix(){
      $parseUrl = parse_url($this->url);
      $this->prefix = $parseUrl['path'] ?? [];
    }
        
    /**
     * Adiciona uma rota na classe
     *
     * @param  string $method
     * @param  string $route
     * @param  array $params
     */
    private function addRoute($method, $route, $params = []){
        //valida os parametros - troca o Closure para 'controller'
        foreach ($params as $key => $value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }
        //padrão de validação da URL
        $patternRoute = '/^'.str_replace('/', '\/', $route) . '$';
        $this->routes[$patternRoute] [$method] = $params;

    }

    /**
     * Define uma rota de GET
     *
     * @param  string $route
     * @param  array $params
     */
    public function get($route, $params = []){
        return $this->addRoute('GET', $route, $params);
    }
    
    /**
     * Retorna a URI desconsiderando o prefixo
     *
     */
    private function getUri(){
        $uri = $this->request->getUri();     
        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri]; //fatia a uri com prefixo
        return end($xUri); //retorna o último valor do array (uri sem prefixo)
    }

    /**
     * Retorna os dados da rota atual
     *
     * @return array
     */
    private function getRoute(){ 

        $uri = $this->getUri();     
        $httpMethod = $this->request->getHttpMethod();
        
        //valida as rotas
        foreach ($this->routes as $patternRoute=>$methods) {
            //verifica se a uri bate com o padrão
            if(preg_match($patternRoute, $uri)){
                //verifica o método
                if($methods[$httpMethod]){
                    return $methods[$httpMethod];
                }
                throw new Exception("Método não permitido", 405);
                
            }
        }
        throw new Exception("URL não encontrada", 404);
    }
    
    /**
     * executa a rota atual
     *
     * @return Response uma instância de response
     */
    public function run(){
        try {
            $route = $this->getRoute(); //pega a rota atual
            echo "<pre>"; print_r($route); echo "</pre>"; 
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    //echo "<pre>"; print_r($this); echo "</pre>"; 
}