<?php

namespace App\Repositories\Blog;

use App\Repositories\RepositoriesInterface;
use App\Models\Product;
use App\Models\Blog;
use App\Repositories\Baserepositories;

class BlogRepository extends Baserepositories implements BlogRepositoryInterface{

    public function getModel()
    {
        return Blog::class;
    }

    public function getLatestBlogs($limit = 3)
    {
        return $this->model->orderBy('id','desc')
            ->limit($limit)
            ->get();
    }
}

