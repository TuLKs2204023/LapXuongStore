<?php

namespace App\Repositories\Blog;

use App\Repositories\RepositoriesInterface;

interface BlogRepositoryInterface extends RepositoriesInterface
{
    public function getLatestBlogs($limit = 3);

}