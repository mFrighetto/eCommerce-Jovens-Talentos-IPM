<?php

namespace App\Model;

use App\Db\Connection;

class ModelCarrinho extends ModelPadrao {
    
    private $usuCodigo;
    private $proCodigo;
    private $carProQuantidade;
    
    public function getUsuCodigo() {
        return $this->usuCodigo;
    }

    public function getProCodigo() {
        return $this->proCodigo;
    }

    public function getCarProQuantidade() {
        return $this->carProQuantidade;
    }

    public function setUsuCodigo($usuCodigo): void {
        $this->usuCodigo = $usuCodigo;
    }

    public function setProCodigo($proCodigo): void {
        $this->proCodigo = $proCodigo;
    }

    public function setCarProQuantidade($carProQuantidade): void {
        $this->carProQuantidade = $carProQuantidade;
    }

    function getTable(){
        return 'tbcarrinho';
    }
    
    function getCarrinho($aWhere){
         $oConnection = Connection::get();
        
        $sql=   'SELECT procodigo,pronome,prodescricao,propreco,carproquantidade '
                . 'FROM tbproduto '
                . 'JOIN tbcarrinho USING (procodigo)'
                . 'WHERE TRUE ';
        foreach ($aWhere as $aCriterio) {
            $sql.= $aCriterio;
        };
        $oResult = pg_query($oConnection,$sql);
        $aData = [];
        while ($aResultado = pg_fetch_assoc($oResult)){
            $aData[] = $aResultado;
        }
        return $aData;
    }
    /*function getProduto($procodigo){
        $aWhere[] = ' AND procodigo = '.$procodigo;
        $dados = $this->getAll($aWhere);
        $this->setProCodigo($dados[0]['procodigo']);
        $this->setProNome($dados[0]['pronome']);
        $this->setProDescricao($dados[0]['prodescricao']);
        $this->setProImgUrl($dados[0]['proimgurl']);
        $this->setProPreco($dados[0]['propreco']);
    }*/
    
    function insertCarrinho(){
        return parent::insert([
            'procodigo'=> $this->getProCodigo(),
            'usucodigo'=> $this->getUsuCodigo(),
            'carproquantidade'=> $this->getCarProQuantidade()
        ]);
    }
    
    function updateCarrinho(){
        return parent::update(
            [
                'carproquantidade'=> $this->getCarProQuantidade()
            ],[
                'procodigo'=> $this->getProCodigo(),
                'usucodigo'=> $_SESSION['usucodigo']
            ]
        );
    }
    
    function deleteProdutoCarrinho(){
        return parent::delete([
            'procodigo'=> $this->getProCodigo(),
            'usucodigo'=> $_SESSION['usucodigo']
        ]);
    }
    /*function updateProduto(){
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
    }*/
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
