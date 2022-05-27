<?php

namespace App\View;

use App\View\ViewPadrao;


class ViewUsuarios extends ViewPadrao
{
    static function getTabelaUsuarios($a){
        $table = '
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col" rowspan="2">#</th>
                    <th scope="col" rowspan="2">Nome</th>
                    <th scope="col" rowspan="2">E-mail</th>
                    <th scope="col" colspan="5" class="text-center">Ações</th>
                  </tr>
                  <tr>
                    <th class="text-center">Alterar</th>
                    <th class="text-center">Reset Senha</th>
                    <th class="text-center">Excluir</th>
                    <th class="text-center">Ativo</th>
                    <th class="text-center">Admin</th>
                  </tr>
                </thead>
                <tbody>';
        foreach ($a as $key => $linha){
            $table .= '<tr>
                        <th scope="row">'.$linha['usucodigo'].'</th>
                        <td>'.$linha['usunome'].'</td>
                        <td>'.$linha['usuemail'].'</td>
                        <td class="text-center"><a class="text-warning" href="?pg=usuario&act=alterar&usucodigo='.$linha['usucodigo'].'"><span class="p-2"><i class="fa-solid fa-pen-to-square"></i></spam></a></td>
                        <td class="text-center"><a class="text-warning" href="?pg=usuario&act=update&usucodigo='.$linha['usucodigo'].'&ususenha=123"><span class="p-2"><i class="fa-solid fa-key"></i></spam></a></td>';
                        if ($linha['usucodigo']==@$_SESSION['usucodigo']){
                            $table .= '<td class="text-center"><span class="p-2"><i class="fa-solid fa-x text-danger"></i></spam></td>'
                                    . '<td class="text-center"><span class="p-2"><i class="fa-solid fa-user text-success"></i></spam></td>'
                                    . '<td class="text-center"><span class="p-2"><i class="fa-solid fa-crown text-success"></i></spam></td>';
                        }else{
                            if($linha['usuativo']=='t'){
                                $usuativo='text-success';
                                $ativar = 0;
                            }else{
                                $usuativo='text-danger'; 
                                $ativar = 1;
                            };
                            switch ($linha['usutipo']){
                                case 1: 
                                    $usutipo='text-danger';
                                    $admin = 2;
                                    break; 
                                case 2: 
                                    $usutipo = 'text-success'; 
                                    $admin = 1;
                                    break;
                            };
                            $table .= '<td class="text-center"><a class="text-danger" href="?pg=usuario&act=delete&usucodigo='.$linha['usucodigo'].'"><span class="p-2"><i class="fa-solid fa-x"></i></spam></a></td>'
                                    . '<td class="text-center"><a class="'.$usuativo.'" href="?pg=usuario&act=update&usucodigo='.$linha['usucodigo'].'&usuativo='.$ativar.'"><span class="p-2"><i class="fa-solid fa-user"></i></spam></a></td>'
                                    . '<td class="text-center"><a class="'.$usutipo.'" href="?pg=usuario&act=update&usucodigo='.$linha['usucodigo'].'&usutipo='.$admin.'"><span class="p-2"><i class="fa-solid fa-crown"></i></spam></a></td>';
                        };
                        
            $table .='</tr>';
        };
        $table .= '   </tbody>
            </table>';
        return $table;
        
    }
    
    
}
