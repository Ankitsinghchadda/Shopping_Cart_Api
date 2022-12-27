<?php

namespace App\Http\Controllers;

use App\Models\Product_SQL;
use Illuminate\Http\Request;

class Product_MySQL_Controller extends Controller
{
    public function insertData(Request $request)
    {
        $product = new Product_SQL();
        return $product->m_insert($request->all());
    }
    public function getData()
    {
        $product = new Product_SQL();
        return $product->m_getData();
    }
}
