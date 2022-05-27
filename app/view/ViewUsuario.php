<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewUsuario extends ViewPadrao {

    function getFormUsuario($sAct,$Model) {
        switch ($sAct) {
            case 'cadastro': 
                return '
                    <div class="card text-light bg-dark" style="width: 50%">
                        <div class="card-header">
                          <h5 class="card-title">Cadastre-se para poder realizar compras na nossa loja!!</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php">
                                <input type="hidden" name="pg" value="usuario" >
                                <input type="hidden" name="act" value="insert" >
                                <div class="mb-3">
                                    <label for="usunome" class="form-label" >Nome Completo</label>
                                    <input class="form-control" type="text" name="usunome" id="usunome" required="required" >
                                </div>
                                <div class="mb-3">
                                    <label for="usuemail" class="form-label" >E-mail:</label>
                                    <input class="form-control" type="email" name="usuemail" id="usuemail" required="required" >
                                </div>
                                <div class="mb-3">
                                    <label for="ususenha" class="form-label">Senha:</label>
                                    <input class="form-control" type="password" name="ususenha" id="ususenha" required="required" >
                                </div>
                                <p>Todos os campos são de preenchimento obrigatório!!<button type="submit" class="btn btn-success float-end">Cadastrar</button></p>
                            </form>
                        </div>
                    </div>
                ';
                break;
            case 'alterar': 
                $form = ' 
                    <div class="card text-light bg-dark" style="width: 50%">
                        <div class="card-header">
                          <h5 class="card-title">Atualização Cadastral</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php">
                                <input type="hidden" name="pg" value="usuario" >
                                <input type="hidden" name="act" value="update" >
                                <input type="hidden" name="usucodigo" value="'.$Model->getUsuCodigo().'" >
                                
                                <div class="mb-3">
                                    <label for="usunome" class="form-label" >Nome Completo</label>
                                    <input class="form-control" type="text" name="usunome" id="usunome" value="'.$Model->getUsuNome().'" required="required" >
                                </div>
                                <div class="mb-3">
                                    <label for="usuemail" class="form-label" >E-mail:</label>
                                    <input class="form-control" type="email" name="usuemail" id="usuemail"  value="'.$Model->getUsuEmail().'" required="required" >
                                </div>
                ';
                if ($_GET['usucodigo']==$_SESSION['usucodigo']){
                    $form .=' 
                                <div class="mb-3">
                                    <label for="ususenha" class="form-label">Senha:</label>
                                    <input class="form-control" type="password" name="ususenha" id="ususenha" required="required" >
                                </div>
                    ';
                }
                $form .='
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success" style="width:100%;" >Atualizar</button>
                                    <p class="text-danger">* Para atualização todos os campos devem ser preenchidos.</p>
                                </div>
                            </form>
                        </div>
                    </div>
                ';
                return $form;
                break;
            
            default :
                return '
                    <div class="card text-light bg-dark" style="width: 50%">
                        <div class="card-header">
                             <h5 class="card-title">Faça seu login</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php">
                                <input type="hidden" name="pg" value="usuario" >
                                <input type="hidden" name="act" value="login" >
                                <div class="mb-3">
                                    <label for="usuemail" class="form-label">E-mail:</label>
                                    <input type="email"  name="usuemail" id="usuemail" class="form-control" required="required" >
                                </div>
                                <div class="mb-3">
                                    <label for="ususenha" class="form-label">Senha:</label>
                                    <input type="password" name="ususenha" id="ususenha" class="form-control" required="required" >
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success" style="width:100%;" >Acessar</button>
                                </div>
                            </form>
                            <br>
                            <a class="fw-bold text-decoration-none" href="index.php?pg=usuario&act=cadastro"><p class="alert alert-warning fw-semibold">Não possui cadastro? Clique aqui e cadastre-se já!!</p></a>
                        </div>
                    </div>
                ';
        }
        
    }

}
