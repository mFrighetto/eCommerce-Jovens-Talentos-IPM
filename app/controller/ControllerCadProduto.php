<?php

namespace App\Controller;

use App\Controller\ControllerProduto;
use App\Model\ModelCadProduto;
use App\View\ViewCadProduto;

class ControllerCadProduto extends ControllerProduto {
    
    
    
    function processPage() {
        if(!$this->getSession()->isAdminLogged()){
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usurário esteja logado e seja do tipo administrador!!!'
            ];

            return $oControllerUsuario->processPage();
        }
        
        if(!isset($oModelCadProduto)){
            
            $oModelCadProduto = new ModelCadProduto;
            $sContent = ViewCadProduto::render(ViewCadProduto::getDadosProduto([]));
            
            if((@$_GET['act']=='altera') or (@$_POST['act']=='update')){
                $oModelCadProduto->getProduto($_GET['procodigo'] ?? $_POST['procodigo']);
                $sContent = ViewCadProduto::render(ViewCadProduto::getDadosProduto($oModelCadProduto));
            };
            
        };
       
        $sTitle = 'FuscaShop - Cadastro de Produtos';
        
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
        return $pWhere;
    }
    
    function processInsert() {
        
        $oModelCadProduto = new ModelCadProduto;
        $oModelCadProduto->setProNome($_POST['pronome']);
        $oModelCadProduto->setProDescricao($_POST['prodescricao']);
        $oModelCadProduto->setProPreco($_POST['propreco']);
        $oModelCadProduto->setProImgUrl($_POST['proimgurl']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        if($oModelCadProduto->insertProduto()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Insclusão do produto realizada com Sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível incluir o produto!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }
    
    function processUpdate() {
        
        $oModelCadProduto = new ModelCadProduto;
        $oModelCadProduto->setProCodigo($_POST['procodigo']);
        $oModelCadProduto->setProNome($_POST['pronome']);
        $oModelCadProduto->setProDescricao($_POST['prodescricao']);
        $oModelCadProduto->setProPreco($_POST['propreco']);
        $oModelCadProduto->setProImgUrl($_POST['proimgurl']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        
        if($oModelCadProduto->updateProduto()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração do produto realizada com Sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível alterar o produto!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }
}