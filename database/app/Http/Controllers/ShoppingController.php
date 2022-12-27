<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{


    public function updateCustomerDetails(Request $request)
    {
        $current_customer = auth()->user();
        if ($current_customer !== null) {
            $data = $request->all('name', 'email', 'contact', 'password');
            foreach ($data as $key => $value) {
                if ($value == null) {
                    unset($data[$key]);
                }
            }
            if (count($data) > 0) {
                $customer = new Customer();
                return $customer->m_updateCustomerDetail($data, $current_customer['_id']) ? response("Customer Details Updated Successfully") : response("No updation in the customer details");
            }

            return response("Error: No value given to update", 400);
        } else return response("Unauthorized", 401);
    }

    public function addToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required|integer',
        ]);
        $current_customer = auth()->user();
        if ($current_customer !== null) {
            $data = $request->all('product_id', 'quantity');
            $customer = new Customer();
            return $customer->m_addToCart($data, $current_customer) ? response("Product added to the card", 200) : response("Error: Adding product to the cart", 400);
        } else return response("Unauthorized", 401);
    }

    public function removeFromCart(Request $request)
    {
        $current_customer = auth()->user();
        if ($current_customer !== null) {
            $product_id = $request->input('product_id');
            $customer = new Customer();
            return $customer->m_removeFromCart($product_id, $current_customer['customer_id']) ? response("Product remove from the card", 200) : response("Error: remove product from the cart", 400);
        } else return response("Unauthorized", 401);
    }

    public function getCartProducts()
    {

        $current_customer = auth()->user();
        if ($current_customer !== null) {
            $customer = new Customer();
            return response($customer->m_getCartProducts($current_customer['customer_id']), 200);
        } else return response("Unauthorized", 401);
    }

    public function buy()
    {
        $current_customer = auth()->user();
        if ($current_customer !== null) {
            $customer = new Customer();
            return response($customer->m_buy($current_customer), 200);
        } else return response("Unauthorized", 401);
    }
}
