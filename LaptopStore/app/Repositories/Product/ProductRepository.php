<?php

namespace App\Repositories\Product;

use App\Models\Cate;
use App\Repositories\RepositoriesInterface;
use App\Models\Product;
use App\Repositories\Baserepositories;
use App\Models\CateGroup;

class ProductRepository extends Baserepositories implements ProductRepositoryInterface{

    public function getModel(){
       
        
        return Product::class;
    }

    public function getRelatedProducts ($product,$limit = 4)
    {
        return $this->model
        ->where('cpu_id',$product->cpu_id)
        ->limit($limit)
        ->get();
    }

    

    public function getProductOnIndex($request)
    {

        $perPage = $request->show ?? 3;
        $sortBy  = $request->sort_by ??'latest';

        switch($sortBy)
        {
            case 'latest';
                $products = $this->model->orderBy('id');
                break;
            case 'oldest':
                $products = $this->model->orderByDesc('id');
                break;
            case 'name-ascending':
                $products = $this->model->orderBy('name');
                break;
            case 'name-descending':
                $products = $this->model->orderByDesc('name');
                // dd($products->get());
                break;
            case 'price-ascending':
                $products = $this->model->orderBy('price');
                break;
            case 'price-descending':
                $products = $this->model->orderByDesc('price');
                break;
            default:
                $products = $this->model->orderBy('id');
        }

        $products = $products->paginate($perPage);
        //paginate() : ham phan trang

        $products->appends(['sort_by'=>$sortBy,'show'=>$perPage]);

        return $products;    

    }
}

