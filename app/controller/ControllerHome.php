<?php

namespace App\Controller;

use App\Controller\ControllerPadrao,
    App\Controller\ControllerProduto,
    App\View\ViewHome,
    App\Model\ModelCarrinho,
    App\Model\ModelProduto,
    App\Client\Session;

class ControllerHome extends ControllerPadrao {

    protected function processPage() {
        
        if (@$_GET['act'] == 'logout') {
            
            (new Session)->logout();
            
        };

        $sTitle = 'FuscaShop';

        $oControllerProduto = new ControllerProduto;
        $oModelProduto = new ModelProduto;
        
        $aWhere = $oControllerProduto->processWhere();

        $a = $oModelProduto->getAll($aWhere);

        $sContent = ViewHome::render([
            'homeContent' => ViewHome::getCards($a)
        ]);

        if (!isset($this->footerVars['footerContent'])) {
            
            $this->footerVars = [
                'footerContent' => ''
            ];
            
        };

        return parent::getPage(
            $sTitle,
            $sContent
        );
    }

    public function processInsert() {
        
        if (!$this->getSession()->isLogged()) {
            
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado!!!'
            ];

            return $oControllerUsuario->processPage();
        }
        $oModelCarrinho = new ModelCarrinho;
        $oModelCarrinho->setUsuCodigo($_SESSION['usucodigo']);
        $oModelCarrinho->setProCodigo($_GET['procodigo']);
        $oModelCarrinho->setCarProQuantidade($_GET['carproquantidade']);

        if (!isset($this->footerVars['footerContent'])) {
            $this->footerVars = [
                'footerContent' => ''
            ];
        }

        if ($oModelCarrinho->insertCarrinho()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Produto Inserido no carrinho com sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível incluir o produto no carrinho!<br>' . pg_last_error() . '</div>'
            ];
        };
        return $this->processPage();
    }

}
