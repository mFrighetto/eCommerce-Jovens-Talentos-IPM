<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewUsuario extends ViewPadrao {

    function getFormUsuario($sAct) {
        switch ($sAct) {
            case 'cadastro': 
                return '
                    <p>Cadastre-se para poder realizar compras na nossa loja!!</p>
                    <form method="post" action="index.php">
                        <input type="hidden" name="pg" value="usuario" >
                        <input type="hidden" name="act" value="insert" >
                        <label for="usunome">Nome Completo</label>
                        <input type="text" name="usunome" id="usunome" required="required" >
                        <label for="usuemail">E-mail:</label>
                        <input type="email" name="usuemail" id="usuemail" required="required" >
                        <label for="ususenha">Senha:</label>
                        <input type="password" name="ususenha" id="ususenha" required="required" >
                        <button type="submit" class="btn btn-success">Acessar</button>
                    </form>
                    <p>Todos os campos são de preenchimento obrigatório!!</p>
                ';
                break;
            default :
                return '
                    <p> Faça seu login</p>
                    <form method="post" action="index.php">
                        <input type="hidden" name="pg" value="usuario" >
                        <input type="hidden" name="act" value="login" >
                        <label for="usuemail">E-mail:</label>
                        <input type="email" name="usuemail" id="usuemail" required="required" >
                        <label for="ususenha">Senha:</label>
                        <input type="password" name="ususenha" id="ususenha" required="required" >
                        <button type="submit" class="btn btn-success">Acessar</button>
                    </form>
                    <p class="alert alert-warning">Não possui cadastro? Clique <a class="btn btn-outline-success" href="index.php?pg=usuario&act=cadastro"> aqui </a> e cadastre-se já!!</p>
                ';
        }
        
    }

}
