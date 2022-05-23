<?php

namespace App\Model;

class ModelProduto extends ModelPadrao {
    
    private $proCodigo;
    private $proNome;
    private $proDescricao;
    private $proImgUrl;
    private $proPreco;
    
    public function getProCodigo() {
        return $this->proCodigo;
    }

    public function getProNome() {
        return $this->proNome;
    }

    public function getProDescricao() {
        return $this->proDescricao;
    }

    public function getProImgUrl() {
        return $this->proImgUrl;
    }

    public function getProPreco() {
        return $this->proPreco;
    }

    public function setProCodigo($proCodigo): void {
        $this->proCodigo = $proCodigo;
    }

    public function setProNome($proNome): void {
        $this->proNome = $proNome;
    }

    public function setProDescricao($proDescricao): void {
        $this->proDescricao = $proDescricao;
    }

    public function setProImgUrl($proImgUrl): void {
        $this->proImgUrl = $proImgUrl;
    }

    public function setProPreco($proPreco): void {
        $this->proPreco = $proPreco;
    }

        
    function getTable(){
        return 'tbproduto';
    }
    
    function deleteProduto(){
        return parent::delete([
            'procodigo'=> $this->getProCodigo()
        ]);
    }
    
        /**
     * Retorna o valor pronto para ser 
     * adicionado no comando SQL
     * @param mixed $xValue
     * @return mixed
     */
    protected function getBdValue($xValue)
    {
        if (!empty($xValue) || !is_null($xValue)) {
            if (is_string($xValue)) {
                return '\'' . pg_escape_string($xValue) . '\'';
            }

            return $xValue;
        }

        return 'NULL';
    }
}
