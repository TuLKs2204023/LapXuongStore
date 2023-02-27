<?php

namespace App\Repositories\ProductComment;

use App\Repositories\RepositoriesInterface;
use App\Models\Product;
use App\Models\ProductComment;
use App\Repositories\Baserepositories;

class ProductCommentRepository extends Baserepositories implements ProductCommentRepositoryInterface{

    public function getModel()
    {
        return ProductComment::class;
    }

}

