<?php

namespace App\View;

use App\View\ViewPadrao;


class ViewCarrinho extends ViewPadrao
{
    static function getTabelaProdutosCarrinho($a){
        $sum=0;
        $table = '
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="text-start">Produto</th>
                    <th scope="col" class="text-start">Descrição</th>
                    <th scope="col" class="text-center">Quantidade</th>
                    <th scope="col" class="text-center">Preço</th>
                    <th scope="col" class="text-center">SubTotal</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>';
        foreach ($a as $key => $linha){
            $table .= '<tr>
                        <th scope="row" style="text-align:justify;" >'.$linha['pronome'].'</td>
                        <td style="text-align:justify;" >'.$linha['prodescricao'].'</td>
                        <td class="text-center">
                            <form action="index.php?pg=carrinho&act=update" method="post">
                                <input type="hidden" name="procodigo" value="'.$linha['procodigo'].'">
                                <input type="number" style="width: 70px;" step="1" min="1"  name="carproquantidade" value="'.intval($linha['carproquantidade']).'">
                                <button type="submit" class="btn btn-outline-success"><i class="fa-solid fa-check"></i></button>
                            </form>
                        </td>
                        <td class="text-center"> R$ '.number_format($linha['propreco'],2,',','.').'</td>
                        <td class="text-center"> R$ '.number_format($linha['carproquantidade']*$linha['propreco'],2,',','.').'</td>
                        <td ><a class="text-danger" href="index.php?pg=carrinho&act=delete&procodigo='.$linha['procodigo'].'"><i class="fa-solid fa-x"></i></a></td>
                        
                      </tr>';
            $sum += $linha['carproquantidade']*$linha['propreco'];
        };
        $table .= ' </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row" colspan="6" class="text-end">Valor Total: R$ '.number_format($sum,2,',','.').'</th>
                        </tr>
                    </tfoot>
                </table>';
        return $table;
        
    }
    
    
}
