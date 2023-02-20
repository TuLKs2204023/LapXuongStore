<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Http\Controllers\FE\HomeController;

class HeaderComposer
{
    public $headerCart;

    /**
     * Create a header composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->headerCart = HomeController::totalCart();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('headerCart', $this->headerCart);
    }
}
