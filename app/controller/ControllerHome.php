<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Controller\ControllerProduto;
use App\View\ViewHome;
use App\Model\ModelCarrinho;
use App\Client\Session;

class ControllerHome extends ControllerPadrao
{

    protected function processPage()
    {
        if (@$_GET['act']=='logout'){
            (new Session)->logout();
            
        }
        
        $sTitle = 'FuscaShop';
        $oControllerProduto = new ControllerProduto;
        $oModelProduto = new \App\Model\ModelProduto;
        $aWhere = $oControllerProduto->processWhere();
        
        $a = $oModelProduto->getAll($aWhere);
        
        $sContent = ViewHome::render([
            // Passar aqui os parâmetros do conteúdo da página
            'homeContent' => ViewHome::getCards($a)
        ]);

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
    
    function processInsert() {
        if(!$this->getSession()->isLogged()){
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usurário esteja logado!!!'
            ];

            return $oControllerUsuario->processPage();
        }
        $oModelCarrinho = new ModelCarrinho;
        $oModelCarrinho->setUsuCodigo($_SESSION['usucodigo']);
        $oModelCarrinho->setProCodigo($_GET['procodigo']);
        $oModelCarrinho->setCarProQuantidade($_GET['carproquantidade']);
        
        if(!isset($this->footerVars['footerContent'])){
            $this->footerVars = [
                'footerContent'=>''
            ];
        }
        
        if($oModelCarrinho->insertCarrinho()){
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Produto Inserido no carrinho com sucesso!</div>'
            ];
        }else{
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi incluir o produto no carrinho!<br>'.pg_last_error().'</div>'
            ];
            
        };
         return $this->processPage();
    }
}
