<?php

namespace App\Model;

use App\Db\Connection;

class ModelUsuario extends ModelPadrao {
    
    private $usuCodigo;
    private $usuNome;
    private $usuEmail;
    private $usuSenha;
    private $usuTipo;
    private $usuAtivo;
    
    public function getUsuCodigo() {
        return $this->usuCodigo;
    }

    public function getUsuNome() {
        return $this->usuNome;
    }

    public function getUsuEmail() {
        return $this->usuEmail;
    }

    public function getUsuSenha() {
        return $this->usuSenha;
    }

    public function getUsuTipo() {
        return $this->usuTipo;
    }

    public function getUsuAtivo() {
        return $this->usuAtivo;
    }

    public function setUsuCodigo($usuCodigo): void {
        $this->usuCodigo = $usuCodigo;
    }

    public function setUsuNome($usuNome): void {
        $this->usuNome = $usuNome;
    }

    public function setUsuEmail($usuEmail): void {
        $this->usuEmail = $usuEmail;
    }

    public function setUsuSenha($usuSenha): void {
        $this->usuSenha = $usuSenha;
    }

    public function setUsuTipo($usuTipo): void {
        $this->usuTipo = $usuTipo;
    }

    public function setUsuAtivo($usuAtivo): void {
        $this->usuAtivo = $usuAtivo;
    }

    function getUsuario($usucodigo){
        $aWhere[] = ' AND usucodigo = '.$usucodigo;
        $dados = $this->getAll($aWhere);
        $this->setUsuCodigo($dados[0]['usucodigo']);
        $this->setUsuNome($dados[0]['usunome']);
        $this->setUsuSenha($dados[0]['ususenha']);
        $this->setUsuTipo($dados[0]['usutipo']);
        $this->setUsuAtivo($dados[0]['usuativo']);
    }
    
    function insertUsuario(){
        return parent::insert([
            'usunome'=> $this->getUsuNome(),
            'usuemail'=> $this->getUsuEmail(),
            'ususenha'=> $this->getUsuSenha(),
            'usutipo'=> $this->getUsuTipo()
        ]);
    }
    
    function getLogin (){
        $sql = ' SELECT usucodigo, usunome, usutipo '
               .' FROM '.$this->getTable()
               .' WHERE TRUE '
               .' AND usuativo = TRUE '
               .' AND usuemail = '.$this->getBdValue($this->getUsuEmail())
               .' AND ususenha = '.$this->getBdValue($this->getUsuSenha());
        $aConsulta = pg_query(Connection::get(),$sql);
        
        
        if (pg_num_rows($aConsulta)==1){
            $aConsulta = pg_fetch_assoc($aConsulta);
            $this->setUsuCodigo($aConsulta['usucodigo']);
            $this->setUsuNome($aConsulta['usunome']);
            $this->setUsuTipo($aConsulta['usutipo']);
            return true;
        } else{
            return false;
        }
    }


    function getTable(){
        return 'tbusuario';
    }
    
    function updateUsuario(){
        $valores =[];
        if (!is_null($this->getUsuNome())){$valores =['usunome' => $this->getUsuNome()];};
        if (!is_null($this->getUsuEmail())){$valores =['usuemail' => $this->getUsuEmail()];};
        if (!is_null($this->getUsuSenha())){$valores =['ususenha' => $this->getUsuSenha()];};
        if (!is_null($this->getUsuAtivo())){$valores =['usuativo' => $this->getUsuAtivo()];};
        if (!is_null($this->getUsuTipo())){$valores =['usutipo' => $this->getUsuTipo()];};

        $condicoes = ['usucodigo' => $this->getUsuCodigo()];

        return parent::update($valores,$condicoes);
    }
    
    function deleteUsuario(){
        return parent::delete([
            'usucodigo'=> $this->getUsuCodigo()
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
