<?php

namespace App\Controller;

use App\View\ViewPage,
    App\View\ViewHeader,
    App\View\ViewFooter,
    App\Client\Session;

abstract class ControllerPadrao {

    public $headerVars = [];
    public $footerVars = [];
    protected $Session;
    private $Model;

    
    public function render() {
        $this->getSession();

        $sAction = $_POST['act'] ??= $_GET['act'] ??= '';

        switch ($sAction) {
            case 'insert':
                return $this->processInsert();
            case 'update':
                return $this->processUpdate();
            case 'delete':
                return $this->processDelete();
        };

        return $this->processPage();
    }
    
    public function getSession() {
        if (!isset($this->Session)) {
            $this->setSession(new Session);
        };
        
        return $this->Session;
    }

    public function setSession($Session): void {
        $this->Session = $Session;
    }
    
    private function getModel() {
        
    }

    private function setModel() {
        
    }

    protected function processInsert() {
        
    }

    protected function processUpdate() {
        
    }

    protected function processDelete() {
        
    }

    protected function processPage() {
        
    }

    protected function processWhere() {
        
    }

    protected function processLogin() {
        
    }

    protected function getHeader($aVars = []) {
        return ViewHeader::render($aVars);
    }

    protected function getFooter($aVars = []) {
        return ViewFooter::render($aVars);
    }

    protected function getPage($sTitle, $sContent) {
        $this->headerVars = [
            'headerMenus' => ViewHeader::montaHeader()
        ];
        
        $sHeader = $this->getHeader($this->headerVars);
        $sFooter = $this->getFooter($this->footerVars);

        return ViewPage::render([
            'title' => $sTitle,
            'header' => $sHeader,
            'content' => $sContent,
            'footer' => $sFooter
        ]);
    }

}
