<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Model\ModelCarrinho;
use App\View\ViewCarrinho;


class ControllerCarrinho extends ControllerPadrao {
    
    function processPage() {
        if(!$this->getSession()->isLogged()){
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usurário esteja logado!!!'
            ];

            return $oControllerUsuario->processPage();
        }
        
        $aWhere = $this->processWhere();
        $oModelCarrinho = new ModelCarrinho;
        $a = $oModelCarrinho->getCarrinho($aWhere);
        $sTitle = 'FuscaShop - Carrinho';
        $sContent = ViewCarrinho::render([
            'tabelaProduto'=>ViewCarrinho::getTabelaProdutosCarrinho($a)
        ]);
        if (count($a)==0){
            $this->footerVars = [
            'footerContent' => '<div class="alert alert-info" role="alert">Você não possui produtos no seu carrinho!!!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => ''
            ];
        }
        
        return parent::getPage(
            $sTitle,
            $sContent
        );
    }
    
    public function processWhere(){
        
        $pWhere = [];
        $pWhere[]=' AND usucodigo = '.$_SESSION['usucodigo'].' ';
        
        return $pWhere;
        
        /*ver que pode ser necessário
         * if(@$_GET['act']=='Filtrar'){
            
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
        }*/
    }
    function processUpdate() {
        
        $oModelCarrinho = new ModelCarrinho;
        $oModelCarrinho->setProCodigo($_POST['procodigo']);
        $oModelCarrinho->setCarProQuantidade($_POST['carproquantidade']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        if($oModelCarrinho->updateCarrinho()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração da quantidade realizada com Sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível alterar a quantidade!<br>'.pg_last_error().'</div>'
            ];
            
        };
        
        return $this->processPage();
    }

    function processDelete() {
        $oModelCarrinho = new ModelCarrinho;
        $oModelCarrinho->setProCodigo($_GET['procodigo']);
        $this->footerVars=[
            'footerContent' => ''
        ];
        
        if($oModelCarrinho->deleteProdutoCarrinho()){
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
