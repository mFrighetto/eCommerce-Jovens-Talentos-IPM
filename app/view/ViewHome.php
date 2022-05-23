<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewHome extends ViewPadrao{

    static function getCards($a){
        $cards = '';
        
        foreach ($a as $key => $linha){
            $cards .= '<div class="card alert alert-secondary mb-3 " style="width: 18rem;">
                            <img src="'.$linha['proimgurl'].'" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">'.$linha['pronome'].'</h5>
                                <p class="card-text">'.$linha['prodescricao'].'</p>
                                <p class="card-text"> R$ '.number_format($linha['propreco'],2,',','.').'</p>
                                <form action="index.php" method="get">
                                    <input type=hidden name="act" value="insert">
                                    <input type=hidden name="procodigo" value="'.$linha['procodigo'].'">
                                    <input type="number" style="width:80px;" step="1" name="carproquantidade" value="1">
                                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i><i class="fa-solid fa-cart-shopping"></i></button>
                                </form>
                            </div>
                        </div>';
     
        }
        return $cards;
    }
        
}
