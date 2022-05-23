<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Model\ModelProduto;
use App\View\ViewProduto;


class ControllerProduto extends ControllerPadrao {
    
    function processPage() {
        if(!$this->getSession()->isAdminLogged()){
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usurário esteja logado e seja do tipo administrador!!!'
            ];

            return $oControllerUsuario->processPage();
        }
        
        $aWhere = $this->processWhere();
        $oModelProduto = new ModelProduto;
        $a = $oModelProduto->getAll($aWhere);
        $sTitle = 'FuscaShop - Produto';
        $sContent = ViewProduto::render([
            'tabelaProduto'=>ViewProduto::getHtmlProdutos($a)
        ]);
        $this->footerVars = [
            'footerContent' => '<div class="alert alert-info" role="alert">A busca retornou '.count($a).' resultados.</div>'
            ];
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
        if (@$_GET['act']=='Alterar'){
            $pWhere[]=" AND procodigo = ".$_GET['procodigo']." ";
        }
        return $pWhere;
    }


    function processDelete() {
        $oModelProduto = new ModelProduto;
        $oModelProduto->setProCodigo($_GET['procodigo']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        if($oModelProduto->deleteProduto()){
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
