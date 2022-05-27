<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewHeader extends ViewPadrao {

    static function montaHeader() {
        $menus = '<li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?pg=home" id="home">
                        <span class="p-2"><i class="fa-solid fa-shop"></i></span>
                        Home
                    </a>
                </li>';
        if (isset($_SESSION['usucodigo'])) {
            if ($_SESSION['usutipo'] >= 1) {
                $menus .= '
                    <li class="nav-item">
                      <a class="nav-link" href="index.php?pg=carrinho" id="carrinho">
                       <span class="p-2"><i class="fa-solid fa-cart-shopping"></i></span>
                       Carrinho
                      </a>
                    </li>';
            };
            if ($_SESSION['usutipo'] >= 2) {
                $menus .= '
                    <li class="nav-item dropdown bg-dark">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuGestao" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="p-2"><i class="fa-solid fa-user-gear"></i></span>Gestão
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownMenuGestao">
                          <li><a class="dropdown-item" href="index.php?pg=usuario&act=consulta" id="usuarios">
                          <span class="p-2"><i class="fa-solid fa-users"></i></span>
                          Usuários</a></li>
                          <li><a class="dropdown-item" href="index.php?pg=produto" id="produto">
                          <span class="p-2"><i class="fa-solid fa-dolly"></i></span>
                          Produtos</a></li>
                          <li><a class="dropdown-item" href="index.php?pg=carrinho&act=pedidos" id="pedidos">
                          <span class="p-2"><i class="fa-solid fa-truck"></i></span>
                          Pedidos</a></li>
                        </ul>
                    </li>';
            };
            
            $menus .= '<li class="nav-item dropdown bg-dark">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLogin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="p-2"><i class="fa-solid fa-user-gear"></i></span>'.$_SESSION['usunome'].'
                </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdownMenuLogin">
                      <li><a class="dropdown-item" href="index.php?pg=usuario&act=alterar&usucodigo='.$_SESSION['usucodigo'].'" id="usuario">
                      <span class="p-2"><i class="fa-solid fa-users"></i></span>
                      Dados pessoais</a></li>
                      <li><a class="dropdown-item" href="index.php?act=logout" id="logout">
                      <span class="p-2"><i class="fa-solid fa-users"></i></span>
                      Logout</a></li>
                    </ul>
                </li>';
        }else{
            $menus .= '
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pg=usuario" id="login">
                    <span class="p-2"><i class="fa-solid fa-user-check"></i></span>
                    Login</a>
                </li>;
            ';
        };
        return $menus;
    }

}
