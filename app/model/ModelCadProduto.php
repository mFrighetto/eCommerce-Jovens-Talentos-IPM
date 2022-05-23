<?php

namespace App\Model;

class ModelCadProduto extends ModelProduto {
    
           
    function getProduto($procodigo){
        $aWhere[] = ' AND procodigo = '.$procodigo;
        $dados = $this->getAll($aWhere);
        $this->setProCodigo($dados[0]['procodigo']);
        $this->setProNome($dados[0]['pronome']);
        $this->setProDescricao($dados[0]['prodescricao']);
        $this->setProImgUrl($dados[0]['proimgurl']);
        $this->setProPreco($dados[0]['propreco']);
    }
    
    function insertProduto(){
        return parent::insert([
            'pronome'=> $this->getProNome(),
            'prodescricao'=> $this->getProDescricao(),
            'proimgurl'=> $this->getProImgUrl(),
            'propreco'=> $this->getProPreco()
        ]);
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
