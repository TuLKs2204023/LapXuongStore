<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Http\Controllers\FE\HeaderController;

class HeaderComposer
{
    public $headerCart, $cateGroups, $header_products;

    /**
     * Create a header composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->headerCart = HeaderController::totalCart();
        $this->cateGroups = HeaderController::cateGroups();
        $this->header_products = HeaderController::header_products();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $view->with([
            'headerCart' => $this->headerCart,
            'cateGroups' => $this->cateGroups,
            'header_products' => $this->header_products,
        ]);
    }
}
