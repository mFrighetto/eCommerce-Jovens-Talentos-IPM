<?php

namespace App\View;

use App\View\ViewPadrao;
use App\View\ViewProduto;

class ViewCadProduto extends ViewPadrao
{
    static function getDadosProduto($pDados){
        if (is_object($pDados)){
            $contentVars = [
                'procodigo'     => $pDados->getProCodigo(),
                'pronome'       => ' value="'.$pDados->getProNome().'" ',
                'prodescricao'  => $pDados->getProDescricao(),
                'proimgurl'     => ' value="'.$pDados->getProImgUrl().'" ',
                'propreco'      => ' value="'.$pDados->getProPreco().'" ',
                'botao'         => 'Alterar',
                'act'           => 'update'
            ];
        }else{
            $contentVars = [
                'procodigo'     => '',
                'pronome'       => '',
                'prodescricao'  => '',
                'proimgurl'     => '',
                'propreco'      => '',
                'botao'         => 'Incluir',
                'act'           => 'insert'
            ];
        };
        return $contentVars;
        
    }
    
    
}
