<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{



    protected $collection = 'products';
    protected $connection = 'mongodb';



    public function m_addProduct($data)
    {
        return DB::collection('products')->insert($data);
    }

    public function m_getAllProducts()
    {
        return DB::collection('products')->get();
    }

    public function m_updateProductDetail($data, $id)
    {
        return DB::collection('products')->where('product_id', $id)->update($data);
    }

    public function m_deleteProduct($id)
    {
        return DB::collection('products')->where('product_id', $id)->delete();
    }

    public function m_filterProduct($filter)
    {
        if (isset($filter['enableOr'])) {
            unset($filter['enableOr']);
            $OrFilter = [];

            foreach ($filter as $key => $value) {
                array_push($OrFilter, [$key => $value]);
            }

            $filter = ['$or' => $OrFilter];
        }


        return DB::collection('products')->raw(function ($collection) use ($filter) {
            return $collection->aggregate([
                ['$match' => $filter]
            ]);
        })->toArray();
    }
}
