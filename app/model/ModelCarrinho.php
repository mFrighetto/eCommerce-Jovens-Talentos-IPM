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

    function getTable() {
        return 'tbcarrinho';
    }

    
    function insertCarrinho() {
        return parent::insert([
                    'procodigo' => $this->getProCodigo(),
                    'usucodigo' => $this->getUsuCodigo(),
                    'carproquantidade' => $this->getCarProQuantidade()
        ]);
    }
    
    function getCarrinho($aWhere) {
        $oConnection = Connection::get();

        $sql = 'SELECT procodigo,pronome,prodescricao,propreco,carproquantidade '
                . 'FROM tbproduto '
                . 'JOIN tbcarrinho USING (procodigo)'
                . 'WHERE TRUE ';
        foreach ($aWhere as $aCriterio) {
            $sql .= $aCriterio;
        };
        $sql .= ' ORDER BY pronome ASC';
        
        $oResult = pg_query($oConnection, $sql);
        $aData = [];
        
        while ($aResultado = pg_fetch_assoc($oResult)) {
            $aData[] = $aResultado;
        };
        
        return $aData;
    }
    
    function getPedidos($aWhere){
        $oConnection = Connection::get();
        $aData=[];
        $i = 0;
        
        $sql =  'SELECT DISTINCT tbcarrinho.usucodigo, tbusuario.usunome, tbusuario.usuemail '
                . ' FROM tbcarrinho JOIN tbusuario USING (usucodigo) WHERE TRUE ORDER BY tbusuario.usunome ASC ';
        
        $dResult = pg_query($oConnection, $sql);
        while ($dResultado = pg_fetch_assoc($dResult)){
            $aData[$i] = $dResultado;
            $sql =  'SELECT tbcarrinho.procodigo, '
                        . 'tbproduto.pronome, '
                        . 'tbproduto.prodescricao, '
                        . 'tbproduto.propreco, '
                        . 'tbcarrinho.carproquantidade '
                    . 'FROM tbcarrinho JOIN tbproduto USING(procodigo) '
                    . 'WHERE TRUE '
                    . 'AND tbcarrinho.usucodigo = '.$dResultado['usucodigo'].' '
                    . 'ORDER BY tbproduto.pronome ASC ';
            
            $pResult = pg_query($oConnection, $sql);
            while ($pResultado = pg_fetch_assoc($pResult)){
                $aData[$i]['produtos'][] = $pResultado;
            };
            $i++;
        };
        
        return $aData;
    }

    function updateCarrinho() {
        return parent::update(
            [
                'carproquantidade' => $this->getCarProQuantidade()
            ], [
                'procodigo' => $this->getProCodigo(),
                'usucodigo' => $_SESSION['usucodigo']
            ]
        );
    }

    function deleteProdutoCarrinho() {
        return parent::delete([
            'procodigo' => $this->getProCodigo(),
            'usucodigo' => $_SESSION['usucodigo']
        ]);
    }

}
