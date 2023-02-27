<?php

namespace App\Service\Cate;


use App\Service\BaseService;
use App\Repositories\Cate\CateRepositoryInterface;

class CateService extends BaseService implements CateServiceInterface{

    public $repository;

    public function __construct(CateRepositoryInterface $CateRepository)
    {
        $this->repository = $CateRepository;
    }

    public function getFeaturedProducts()
    {
        return[
            "office" => $this->repository->getFeaturedProductsByCategory(1),
            "gaming" => $this->repository->getFeaturedProductsByCategory(2),
            
        ];
    }
}

