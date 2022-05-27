<?php

namespace App\Controller;

use App\Controller\ControllerPadrao,
    App\Model\ModelCarrinho,
    App\View\ViewCarrinho;

class ControllerCarrinho extends ControllerPadrao {

    public function getModel() {
        if (!isset($this->Model)) {
            $this->setModel(new ModelCarrinho);
        };
        return $this->Model;
    }

    public function setModel($Model): void {
        $this->Model = $Model;
    }

    function processPage() {
        
        $aWhere = $this->processWhere();

        if (@$_GET['act']=='pedidos'){
            if (!$this->getSession()->isAdminLogged()) {
                $oControllerHome = new ControllerHome;
                $oControllerHome->footerVars = [
                    'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
                ];

                return $oControllerHome->processPage();
            };
            
            $this->footerVars = [
                'footerContent' => ''
            ];
           
            
            $a = $this->getModel()->getPedidos($aWhere);

            $sTitle = 'FuscaShop - Pedidos';
            $sContent = ViewCarrinho::render([
                        'conteudo' => ViewCarrinho::getRelacaoPedidos($a),
                        'titulo' => '<h1>Relação de Pedidos</h1>'
            ]);

        }else{
        
            if (!$this->getSession()->isLogged()) {
                $oControllerUsuario = new ControllerUsuario;
                $oControllerUsuario->footerVars = [
                    'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado!!!'
                ];

                return $oControllerUsuario->processPage();
            };

            $a = $this->getModel()->getCarrinho($aWhere);

            $sTitle = 'FuscaShop - Carrinho';
            $sContent = ViewCarrinho::render([
                        'conteudo' => ViewCarrinho::getTabelaProdutosCarrinho($a),
                        'titulo' => '<h1>Seu carrinho!!</h1><p>Estes são os produtos que você selecionou para comprar. Sinta-se a vontade para realizar ajustes!!!</p>'
            ]);

            if (count($a) == 0) {
                $this->footerVars = [
                    'footerContent' => '<div class="alert alert-info" role="alert">Você não possui produtos no seu carrinho!!!</div>'
                ];
            } else {
                $this->footerVars = [
                    'footerContent' => ''
                ];
            };
        };
        
        return parent::getPage(
            $sTitle,
            $sContent
        );
    }

    public function processWhere() {

        $pWhere = [];
        
        if (@$_GET['act']!='pedidos'){
            
            $pWhere[] = ' AND usucodigo = ' . $_SESSION['usucodigo'] . ' ';
            
        };
        
        return $pWhere;
    }
    
    function processUpdate() {
        
        if (!$this->getSession()->isLogged()) {
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado!!!'
            ];

            return $oControllerUsuario->processPage();
        };

        $this->getModel()->setProCodigo($_POST['procodigo']);
        $this->getModel()->setCarProQuantidade($_POST['carproquantidade']);
        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->updateCarrinho()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração da quantidade realizada com Sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível alterar a quantidade!<br>' . pg_last_error() . '</div>'
            ];
        };

        return $this->processPage();
    }

    function processDelete() {
        
        if (!$this->getSession()->isLogged()) {
            $oControllerUsuario = new ControllerUsuario;
            $oControllerUsuario->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado!!!'
            ];

            return $oControllerUsuario->processPage();
        };

        $this->getModel()->setProCodigo($_GET['procodigo']);
        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->deleteProdutoCarrinho()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Exclusão realizada com Sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível excluir o registro!<br>' . pg_last_error() . '</div>'
            ];
        };

        return $this->processPage();
    }

}
