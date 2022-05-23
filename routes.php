<?php

/**
 * Rederiza o conteúdo da página solicitada
 * @param string $sPage
 * @return string
 */
function render($sPage)
{
    switch ($sPage) {
        case 'home':
            return (new App\Controller\ControllerHome)->render();
            break;
        case 'usuario':
            return (new App\Controller\ControllerUsuario)->render();
            break;
        case 'produto':
            return (new App\Controller\ControllerProduto)->render();
            break;
        case 'cadproduto':
            return (new App\Controller\ControllerCadProduto)->render();
            break;
        case 'carrinho':
            return (new App\Controller\ControllerCarrinho)->render();
            break;
    }

    return 'Página não encontrada!';
}
