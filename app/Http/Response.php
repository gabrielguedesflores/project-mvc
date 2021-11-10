<?php 

namespace App\Http;

class Response
{    
    /**
     * Status codigo HTTP
     *
     * @var integer
     */
    private $httpCode = 200;
    
    /**
     * headers da requisição
     *
     * @var array
     */
    private $headers = [];
    
    /**
     * contentType da requisição 
     *
     * @var string
     */
    private $contentType = 'text/html';

     /**
     * conteúdo do Response 
     *
     * @var mixed 
     */
    private $content;
    
    /**
     * Vai iniciar a clase e definir os valores
     *
     * @param  integer $httpCode
     * @param  mixed $content
     * @param  string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content    = $content;
        $this->setContentType($contentType);
    }
    
    /**
     * Altera o contentType do response
     *
     * @param  string $contentType
     */
    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }
    
    /**
     * Adiciona o conteúdo do registro nos headers do response
     *
     * @param  string $key
     * @param  string $value
     */
    public function addHeader($key, $value){
        $this->headers[$key] = $value;
    }
        
    /**
     * Envia os headers para o navegador
     *
     */
    private function sendHeaders(){
        http_response_code($this->httpCode); //definir o código de status
        foreach($this->headers as $key => $value){
            header($key .': '.$value);
        }
    }
    /**
     * Envia a resposta para o usuário
     *
     */
    public function sendResponse(){
        $this->sendHeaders();
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }


    }

}