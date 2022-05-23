<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Model\ModelUsuario;
use App\View\ViewUsuario;
use App\View\ViewUsuarios;
use App\Client\Session;


class ControllerUsuario extends ControllerPadrao
{
    private $ModelUsuario;
    
    public function getModelUsuario() {
        if (!isset($this->ModelUsuario)){
            $this->setModelUsuario(new ModelUsuario);
        };
        return $this->ModelUsuario ;
    }

    public function setModelUsuario($ModelUsuario): void {
        $this->ModelUsuario = $ModelUsuario;
    }

    public function processPage()
    {
        $sTitle = 'FuscaShop';

        if (!isset($sAct)){
            $sAct = $_GET['act'] ?? $_POST['act'] ?? '';
        };
        if ($sAct == 'login'){
            if($this->processLogin()){
                $oControlerHome = new ControllerHome;
                $oControlerHome->footerVars = [
                    'footerContent'=>'<div class="alert alert-success" role="alert"> Login realizado com sucesso!!</div>'
                ];
                $_SESSION['usucodigo']= $this->ModelUsuario->getUsuCodigo();
                $_SESSION['usunome']= $this->ModelUsuario->getUsuNome();
                $_SESSION['usutipo']= $this->ModelUsuario->getUsuTipo();
                return $oControlerHome->processPage();
                
            } else {
                $this->footerVars = [
                    'footerContent'=>'<div class="alert alert-danger" role="alert">Login Inválido!! Tente novamente!!</div>'
                ];
            };
        };
        
        if (in_array($sAct,['consulta','delete','update'])){
            $aWhere = $this->processWhere();
            $a = $this->getModelUsuario()->getAll($aWhere);
            
            $sTitle = 'FuscaShop - Gestão de Usuários';
            $sContent = ViewUsuarios::render([
                'tabelaUsuarios'=>ViewUsuarios::getTabelaUsuarios($a)
             ]);
        $this->footerVars = [
            'footerContent' => '<div class="alert alert-info" role="alert">A busca retornou '.count($a).' resultados.</div>'
            ];
            
        }else{
        
            $sContent = ViewUsuario::render([
                // Passar aqui os parâmetros do conteúdo da página
                'formContent' => ($oViewUsuario = new ViewUsuario)->getFormUsuario($sAct)
            ]);
        };

        if(!isset($this->footerVars['footerContent'])){
            $this->footerVars = [
                'footerContent'=>''
            ];
        }

        return parent::getPage(
            $sTitle,
            $sContent
        );
    }
    
    protected function processLogin() {
        $this->getModelUsuario()->setUsuEmail($_POST['usuemail']);
        $this->getModelUsuario()->setUsuSenha(sha1($_POST['ususenha']));
        
        return $this->getModelUsuario()->getLogin();
    }   
    
    public function processWhere(){
        $pWhere = [];
        
        if(@$_GET['act']=='Filtrar'){
            
            if($_GET['pronome']!=''){
                $pWhere[]=" AND pronome ILIKE '%".$_GET['pronome']."%' ";
            };
            if($_GET['prodescricao']!=''){
                $pWhere[]=" AND prodescricao ILIKE '%".$_GET['prodescricao']."%' ";
            };
            if($_GET['propreco']!=''){
                $pWhere[]=' AND propreco = '.$_GET['propreco'].' ';
            };
            
        };
        if (@$_GET['act']=='Alterar'){
            $pWhere[]=" AND procodigo = ".$_GET['procodigo']." ";
        }
        return $pWhere;
    }
    

    function processInsert() {
        
        $oModelUsuario = new ModelUsuario;
        $oModelUsuario->setUsuNome($_POST['usunome']);
        $oModelUsuario->setUsuEmail($_POST['usuemail']);
        $oModelUsuario->setUsuSenha(sha1($_POST['ususenha']));
        $oModelUsuario->setUsuTipo($_POST['usutipo'] ?? 1);
        
        if(!isset($this->footerVars['footerContent'])){
            $this->footerVars = [
                'footerContent'=>''
            ];
        }
        
        if($oModelUsuario->insertUsuario()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Cadastro de Usuário realizado com Sucesso!</div>'
            ];
        }else{
            $sAct = 'cadastro';
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi realizar o seu cadastro!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }
    
    function processUpdate() {
        $this->getModelUsuario()->setUsuCodigo($_GET['usucodigo']);
        $this->getModelUsuario()->setUsuNome(@$_GET['usunome']);
        $this->getModelUsuario()->setUsuEmail(@$_GET['usuemail']);
        $this->getModelUsuario()->setUsuSenha(@$_GET['ususenha']);
        $this->getModelUsuario()->setUsuAtivo(@$_GET['usuativo']);
        $this->getModelUsuario()->setUsuTipo(@$_GET['usutipo']);
                
        if($this->getModelUsuario()->updateUsuario()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração de usuário realizada com Sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível realizar a alteração do usuário!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }
    
    function processDelete() {
        $this->getModelUsuario()->setUsuCodigo($_GET['usucodigo']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        if($this->getModelUsuario()->deleteUsuario()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Exclusão realizada com Sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível excluir o registro!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }
}
