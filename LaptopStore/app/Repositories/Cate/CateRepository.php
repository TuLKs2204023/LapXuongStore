<?php

namespace App\Repositories\Cate;

use App\Repositories\RepositoriesInterface;
use App\Models\Product;
use App\Models\Cate;
use App\Models\CateGroup;
use App\Repositories\Baserepositories;

class CateRepository extends Baserepositories implements CateRepositoryInterface{

    public function getModel()
    {
        return CateGroup::class;
    }

    public function getFeaturedProductsByCategory(int $categoryId)
    {
        return $this->model
        ->where('id',$categoryId)
        ->get();
    }
}

