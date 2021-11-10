<?php 

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

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

        $params['variables'] = []; //variáveis da rota
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //padrão de validação da URL
        $patternRoute = '/^'.str_replace('/', '\/', $route) . '$/';
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
     * Define uma rota de POST
     *
     * @param  string $route
     * @param  array $params
     */
    public function post($route, $params = []){
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Define uma rota de PUT
     *
     * @param  string $route
     * @param  array $params
     */
    public function put($route, $params = []){
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Define uma rota de DELETE
     *
     * @param  string $route
     * @param  array $params
     */
    public function delete($route, $params = []){
        return $this->addRoute('DELETE', $route, $params);
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
            if(preg_match($patternRoute, $uri, $matches)){
                //verifica o método
                if(isset($methods[$httpMethod])){
                    unset($matches[0]); //recebe em um objeto os parâmetros informados na URL e retira a posição 0
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    //echo "<pre>"; print_r($methods); echo "</pre>"; exit;
                    
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
            if(!isset($route['controller'])){
                throw new Exception("URL não pôde ser processada", 500);
            }
            $args =[];

            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';   
            }

            //echo "<pre>"; print_r($args); echo "</pre>"; exit;
            return call_user_func_array($route['controller'], $args);
            //echo "<pre>"; print_r($route); echo "</pre>"; exit;
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    //echo "<pre>"; print_r($this); echo "</pre>"; 
}