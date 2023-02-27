<?php

namespace App\Service\Blog;


use App\Service\BaseService;
use App\Repositories\Blog\BlogRepositoryInterface;

class BlogService extends BaseService implements BlogServiceInterface{

    public $repository;

    public function __construct(BlogRepositoryInterface $BlogRepository)
    {
        $this->repository = $BlogRepository;
    }

    public function getLatestBlogs($limit = 3)
    {
        return $this->repository->getLatestBlogs($limit);
            
    }
}

