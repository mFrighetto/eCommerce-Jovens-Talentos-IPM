<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Model\ModelProduto;
use App\View\ViewCadProduto;
use App\View\ViewProduto;

class ControllerProduto extends ControllerPadrao {

    public function getModel() {
        if (!isset($this->Model)) {
            $this->setModel(new ModelProduto);
        };
        return $this->Model;
    }

    public function setModel($Model): void {
        $this->Model = $Model;
    }

    function processPage() {

        if (!$this->getSession()->isAdminLogged()) {
            $oControllerHome = new ControllerHome;
            $oControllerHome->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
            ];

            return $oControllerHome->processPage();
        };

        $sTitle = 'FuscaShop - Gestão de Produtos';

        if (@$_GET['act'] == 'cadproduto') {

            $sTitle = 'FuscaShop - Cadastro de Produto';
            $sContent = ViewCadProduto::render(ViewCadProduto::getDadosProduto([]));
        } else {

            if ((@$_GET['act'] == 'altera') or (@$_POST['act'] == 'update')) {

                $this->getModel()->getProduto($_GET['procodigo'] ?? $_POST['procodigo']);

                $sTitle = 'FuscaShop - Cadastro de Produto';
                $sContent = ViewCadProduto::render(ViewCadProduto::getDadosProduto($this->getModel()));
            } else {
                
                $aWhere = $this->processWhere();
                $a = $this->getModel()->getAll($aWhere);

                $sContent = ViewProduto::render([
                            'tabelaProduto' => ViewProduto::getHtmlProdutos($a)
                ]);
                
                if (!isset($this->footerVars['footerContent'])) {
                    $this->footerVars = [
                        'footerContent' => '<div class="alert alert-info" role="alert">A busca retornou ' . count($a) . ' resultados.</div>'
                    ];
                };
            };
        };

        if (!isset($this->footerVars['footerContent'])) {
            $this->footerVars = [
                'footerContent' => ''
            ];
        }


        return parent::getPage(
                        $sTitle,
                        $sContent
        );
    }

    function processInsert() {
        if (!$this->getSession()->isAdminLogged()) {
            $oControllerHome = new ControllerHome;
            $oControllerHome->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
            ];

            return $oControllerHome->processPage();
        };
        
        $this->getModel()->setProNome($_POST['pronome']);
        $this->getModel()->setProDescricao($_POST['prodescricao']);
        $this->getModel()->setProPreco($_POST['propreco']);
        $this->getModel()->setProImgUrl($_POST['proimgurl']);

        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->insertProduto()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Insclusão do produto realizada com Sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível incluir o produto!<br>' . pg_last_error() . '</div>'
            ];
        };

        return $this->processPage();
    }

    public function processWhere() {
        $pWhere = [];
        if (@$_GET['act'] == 'Filtrar') {

            if ($_GET['pronome'] != '') {
                $pWhere[] = " AND pronome ILIKE '%" . $_GET['pronome'] . "%' ";
            };
            if ($_GET['prodescricao'] != '') {
                $pWhere[] = " AND prodescricao ILIKE '%" . $_GET['prodescricao'] . "%' ";
            };
            if ($_GET['propreco'] != '') {
                $pWhere[] = ' AND propreco = ' . $_GET['propreco'] . ' ';
            };
        };
        
        if (@$_GET['act'] == 'Alterar') {
            $pWhere[] = " AND procodigo = " . $_GET['procodigo'] . " ";
        };
        
        return $pWhere;
    }

    function processUpdate() {
        if (!$this->getSession()->isAdminLogged()) {
            $oControllerHome = new ControllerHome;
            $oControllerHome->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
            ];

            return $oControllerHome->processPage();
        };
        
        $this->getModel()->setProCodigo($_POST['procodigo']);
        $this->getModel()->setProNome($_POST['pronome']);
        $this->getModel()->setProDescricao($_POST['prodescricao']);
        $this->getModel()->setProPreco($_POST['propreco']);
        $this->getModel()->setProImgUrl($_POST['proimgurl']);

        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->updateProduto()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração do produto realizada com Sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível alterar o produto!<br>' . pg_last_error() . '</div>'
            ];
        };

        return $this->processPage();
    }

    function processDelete() {
        if (!$this->getSession()->isAdminLogged()) {
            $oControllerHome = new ControllerHome;
            $oControllerHome->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
            ];

            return $oControllerHome->processPage();
        };
        
        $this->getModel()->setProCodigo($_GET['procodigo']);
        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->deleteProduto()) {
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
