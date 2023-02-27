<?php

namespace App\Repositories\Cate;

use App\Repositories\RepositoriesInterface;

interface CateRepositoryInterface extends RepositoriesInterface
{
    public function getFeaturedProductsByCategory(int $categoryId);

}