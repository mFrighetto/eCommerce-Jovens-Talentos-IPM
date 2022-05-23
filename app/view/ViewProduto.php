<?php

namespace App\View;

use App\View\ViewPadrao;


class ViewProduto extends ViewPadrao
{
    static function getHtmlProdutos($a){
        $table = '
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Descrição</th>
                    <th scope="col" class="text-center">Preço</th>
                    <th scope="col" colspan="2" class="text-center">Ação</th>
                  </tr>
                </thead>
                <tbody>';
        foreach ($a as $key => $linha){
            $table .= '<tr>
                        <th scope="row">'.$linha['procodigo'].'</th>
                        <td>'.$linha['pronome'].'</td>
                        <td>'.$linha['prodescricao'].'</td>
                        <td class="text-center"> R$ '.number_format($linha['propreco'],2,',','.').'</td>
                        <td class="text-center"><a class="text-warning" href="?pg=cadproduto&act=altera&procodigo='.$linha['procodigo'].'"><span class="p-2"><i class="fa-solid fa-pen-to-square"></i></spam></a></td>
                        <td class="text-center"><a class="text-danger" href="?pg=produto&act=delete&procodigo='.$linha['procodigo'].'"><span class="p-2"><i class="fa-solid fa-x"></i></spam></a></td>
                      </tr>';
        };
        $table .= '   </tbody>
            </table>';
        return $table;
        
    }
    
    
}
