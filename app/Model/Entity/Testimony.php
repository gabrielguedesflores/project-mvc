<?php
namespace App\Model\Entity;

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
        
    }


}