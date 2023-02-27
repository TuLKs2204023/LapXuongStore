<?php

namespace App\Service\Cate;

use App\Service\ServiceInterface;

interface CateServiceInterface extends ServiceInterface
{
    public function getFeaturedProducts();

}