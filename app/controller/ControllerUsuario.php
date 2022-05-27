<?php

namespace App\Controller;

use App\Controller\ControllerPadrao;
use App\Model\ModelUsuario;
use App\View\ViewUsuario;
use App\View\ViewUsuarios;
use App\Client\Session;

class ControllerUsuario extends ControllerPadrao {

    public function getModel() {
        if (!isset($this->Model)) {
            $this->setModel(new ModelUsuario);
        };
        return $this->Model;
    }

    public function setModel($Model): void {
        $this->Model = $Model;
    }

    public function processPage() {
        $sTitle = 'FuscaShop';

        if (!isset($sAct)) {
            $sAct = $_GET['act'] ?? $_POST['act'] ?? '';
        };
        
        if ($sAct == 'login') {
            
            if ($this->processLogin()) {
                
                $oControlerHome = new ControllerHome;
                $oControlerHome->footerVars = [
                    'footerContent' => '<div class="alert alert-success" role="alert"> Login realizado com sucesso!!</div>'
                ];
                
                $_SESSION['usucodigo'] = $this->getModel()->getUsuCodigo();
                $_SESSION['usunome'] = $this->getModel()->getUsuNome();
                $_SESSION['usutipo'] = $this->getModel()->getUsuTipo();
                
                return $oControlerHome->processPage();
            } else {
                $this->footerVars = [
                    'footerContent' => '<div class="alert alert-danger" role="alert">Login Inválido!! Tente novamente!!</div>'
                ];
            };
        };
        
        if (($sAct == 'update')&&(!$this->getSession()->isAdminLogged())){
            return (new ControllerHome())->processPage();
        };
        
        if (in_array($sAct, ['consulta', 'delete', 'update'])) {
            
            if (!$this->getSession()->isAdminLogged()) {
                $oControllerHome = new ControllerHome;
                $oControllerHome->footerVars = [
                    'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
                ];

                return $oControllerHome->processPage();
            };
            
            $aWhere = $this->processWhere();
            $a = $this->getModel()->getAll($aWhere);

            $sTitle = 'FuscaShop - Gestão de Usuários';
            $sContent = ViewUsuarios::render([
                'tabelaUsuarios' => ViewUsuarios::getTabelaUsuarios($a)
            ]);
            
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-info" role="alert">A busca retornou ' . count($a) . ' resultados.</div>'
            ];
            
        } else {
            if ($sAct == 'alterar'){
                $this->getModel()->getUsuario($_GET['usucodigo']);
                if (!(($this->getSession()->isAdminLogged())||(($this->getSession()->isLogged()) && ($this->getModel()->getUsuCodigo() == $_SESSION['usucodigo'])))) {
                
                    $oControllerHome = new ControllerHome;
                    $oControllerHome->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
                    ];

                    return $oControllerHome->processPage();
                };
                
            };
            $sContent = ViewUsuario::render([
                        'formContent' => ($oViewUsuario = new ViewUsuario)->getFormUsuario($sAct,$this->getModel())
            ]);
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

    protected function processLogin() {
        
        $this->getModel()->setUsuEmail($_POST['usuemail']);
        $this->getModel()->setUsuSenha(sha1($_POST['ususenha']));

        return $this->getModel()->getLogin();
    }

    function processInsert() {

        $this->getModel()->setUsuNome($_POST['usunome']);
        $this->getModel()->setUsuEmail($_POST['usuemail']);
        $this->getModel()->setUsuSenha(sha1($_POST['ususenha']));
        $this->getModel()->setUsuTipo($_POST['usutipo'] ?? 1);

        if (!isset($this->footerVars['footerContent'])) {
            $this->footerVars = [
                'footerContent' => ''
            ];
        };

        if ($this->getModel()->insertUsuario()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Cadastro de Usuário realizado com Sucesso!</div>'
            ];
        } else {
            $sAct = 'cadastro';
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi realizar o seu cadastro!<br>' . pg_last_error() . '</div>'
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
        if ((isset($_GET['usuativo']))or(isset($_GET['usutipo']))or(isset($_GET['ususenha']))){
            
            if (!$this->getSession()->isAdminLogged()) {
                $oControllerHome = new ControllerHome;
                $oControllerHome->footerVars = [
                    'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado e seja do tipo administrador!!!</div>'
                ];

                return $oControllerHome->processPage();
            };
        };
        
        $this->getModel()->setUsuCodigo(@$_GET['usucodigo'] ?? @$_POST['usucodigo'] );
        $this->getModel()->setUsuNome(@$_GET['usunome'] ?? @$_POST['usunome']);
        $this->getModel()->setUsuEmail(@$_GET['usuemail'] ?? @$_POST['usuemail']);
        $this->getModel()->setUsuSenha(@$_GET['ususenha'] ?? @$_POST['ususenha']);
        $this->getModel()->setUsuAtivo(@$_GET['usuativo'] ?? @$_POST['usuativo']);
        $this->getModel()->setUsuTipo(@$_GET['usutipo'] ?? @$_POST['usutipo']);

        if ($this->getModel()->updateUsuario()) {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-success" role="alert">Alteração de usuário realizada com Sucesso!</div>'
            ];
        } else {
            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">Não foi possível realizar a alteração do usuário!<br>' . pg_last_error() . '</div>'
            ];
        };

        return $this->processPage();
    }

    function processDelete() {
        
        if (!$this->getSession()->isLogged()) {

            $this->footerVars = [
                'footerContent' => '<div class="alert alert-danger" role="alert">A ação acessada exige que o usuário esteja logado!!!'
            ];

            return $this->processPage();
        }

        $this->getModel()->setUsuCodigo($_GET['usucodigo']);
        $this->footerVars = [
            'footerContent' => ''
        ];

        if ($this->getModel()->deleteUsuario()) {
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
