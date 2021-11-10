<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    
    /**
     * Id do depoimento
     *
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário que fez o depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * Mensagem do depoimento
     *
     * @var string
     */
    public $mensagem;

    /**
     * Data da publicação do depoimento
     *
     * @var string
     */
    public $data;
    
    /**
     * Cadastra a instância atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        $this->data = date('Y-m-d H:i:s');
        $this->id = (new Database('depoimentos'))->insert([
            'nome'            => $this->nome,
            'mensagem' => $this->mensagem,
            'data'              => $this->data   
        ]);
        echo "<pre>"; print_r($this); echo "</pre>"; exit;
    }


}