<?php

namespace App\Model;

use App\Db\Connection;


abstract class ModelPadrao
{
    
    abstract function getTable();

    function getAll($aWhere)
    {
        $oConnection = Connection::get();
        
        $sql= 'SELECT * FROM '.$this->getTable().' WHERE TRUE ';
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

    
    protected function insert($aValues)
    {
        $sql = 'INSERT INTO '.$this->getTable().' (';
        foreach ($aValues as $key => $value) {
            $sql .= $key.', ';
        }
        $sql = trim($sql,', ');
        $sql .=') VALUES (';
        foreach ($aValues as $key => $value) {
            $sql .= $this->getBdValue($value).',';
        }
        $sql = trim($sql,', ');
        $sql .=')';
        return pg_query(Connection::get(),$sql);
        
    }
        

    protected function delete($aWhere)
    {
        $sql = 'DELETE FROM '. $this->getTable().' WHERE TRUE ';
        foreach ($aWhere as $cColuna => $aValor){
            $sql .= ' AND '.$cColuna.' = '.$aValor;
        };
        
        return pg_query(Connection::get(),$sql);
    }

    protected function update($aValues, $aWhere)
    {
        $sql = 'UPDATE '.$this->getTable().' SET ';
        
        foreach ($aValues as $cColuna => $aValor){
            $sql .= $cColuna.' = '.$this->getBdValue($aValor).', ';
        };
        $sql = trim($sql,', ').' WHERE TRUE ';
        
        foreach ($aWhere as $cColuna => $aValor){
            $sql .= ' AND '.$cColuna.' = '.$aValor;
        };
        
        return pg_query(Connection::get(),$sql);
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
