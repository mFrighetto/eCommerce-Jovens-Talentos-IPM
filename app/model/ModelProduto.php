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
    
    function insertProduto(){
        return parent::insert([
            'pronome'=> $this->getProNome(),
            'prodescricao'=> $this->getProDescricao(),
            'proimgurl'=> $this->getProImgUrl(),
            'propreco'=> $this->getProPreco()
        ]);
    }
    
    function getProduto($procodigo){
        $aWhere[] = ' AND procodigo = '.$procodigo;
        $dados = $this->getAll($aWhere);
        $this->setProCodigo($dados[0]['procodigo']);
        $this->setProNome($dados[0]['pronome']);
        $this->setProDescricao($dados[0]['prodescricao']);
        $this->setProImgUrl($dados[0]['proimgurl']);
        $this->setProPreco($dados[0]['propreco']);
    }
    
    function updateProduto(){
        return parent::update(
            [
                'pronome'=> $this->getProNome(),
                'prodescricao'=> $this->getProDescricao(),
                'proimgurl'=> $this->getProImgUrl(),
                'propreco'=> $this->getProPreco()
            ],[
                'procodigo'=> $this->getProCodigo()
            ]
        );
    }
    
    function deleteProduto(){
        return parent::delete([
            'procodigo'=> $this->getProCodigo()
        ]);
    }
    
}
