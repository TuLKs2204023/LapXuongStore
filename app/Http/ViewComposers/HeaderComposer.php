<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Http\Controllers\FE\HeaderController;

class HeaderComposer
{
    public $headerCart, $cateGroups;

    /**
     * Create a header composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->headerCart = HeaderController::totalCart();
        $this->cateGroups = HeaderController::cateGroups();
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
            'cateGroups' => $this->cateGroups
        ]);
    }
}
