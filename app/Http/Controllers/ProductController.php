<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Product_SQL;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // mongodb function
    public function addProduct(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'product_id' => 'required|unique:products',
            'price' => 'required|integer',
            'brand' => 'required',
            'type' => 'required'
        ]);

        $product = new Product();
        $data = $request->all();
        unset($data['password']);
        return $product->m_addProduct($data)
            ? response("Product entered successfully.", 200)
            : response("Error while entering Product", 400);
    }

    // mySQL function
    public function  addProductSQL(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required|integer',
            'description' => 'required'
        ]);
        $product = new Product_SQL();
        return $product->m_insert($request->all())
            ? response("Product entered successfully in MySQL database.", 200)
            : response("Error while entering Product", 400);
    }

    public function getProductSQL(Request $request)
    {
        $product = new Product_SQL();
        return $product->m_getData();
    }

    public function getAllProducts()
    {
        $products = new Product();
        return response($products->m_getAllProducts(), 200);
    }

    public function updateProductDetail(Request $request, $id)
    {
        $data = $request->all();
        unset($data['password']);
        if (count($data) > 0) {

            $employee = new Product();
            return $employee->m_updateEmployeeDetail($data, $id) ? response("Product Details Updated Succesfully", 200) : response("Error: while updating Procuct details", 400);
        } else {
            response("Please provide values to update", 401);
        }
    }

    public function deleteProduct(Request $request)
    {
        $product = new Product();
        return $product->m_deleteProduct($request->product_id) ? response("Product Details Delted Successfully", 200) : response("Error: In Deleting the Product Details", 400);
    }

    public function filterProducts(Request $request)
    {
        $filter = $request->all();

        if (count($filter) > 0) {
            $empl = new Product();
            return response($empl->m_filterProduct($filter), 200);
        }
        return response("Please give some data to filter", 400);
    }
}
