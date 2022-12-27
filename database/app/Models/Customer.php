<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Jenssegers\Mongodb\Eloquent\Model;

class Customer  extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;


    protected $collection = 'customers';


    public function m_addCustomer($data)
    {
        return DB::collection('customers')->insert($data);
    }

    public function m_getSpecificCustomer($id)
    {
        return DB::collection('customers')->where('customer_id', $id)->first();
    }

    public function m_getAllCustomers()
    {
        return DB::collection('customers')->get();
    }

    public function m_updateCustomerDetail($data, $id)
    {
        return DB::collection('customers')->where('_id', $id)->update($data);
    }

    private function authenticateCustomer($id, $password)
    {
        $cust = DB::collection('customers')->where('customer_id', $id)->first();
        if ($cust['password'] == $password) {
            return true;
        }
        return false;
    }

    public function m_addToCart($data, $customer_detail)
    {

        $products = $customer_detail['cart'];
        $exist = false;
        foreach ($products as $key => $value) {
            // print_r($value);
            if ($value["product_id"] == $data['product_id']) {
                $exist = true;
            }
        }

        if (!$exist) {
            return DB::collection('customers')->raw(function ($collection) use ($data, $customer_detail) {
                return $collection->updateOne(
                    ['customer_id' => $customer_detail['customer_id']],
                    ['$push' => ['cart' => ['product_id' => $data['product_id'], 'pQuantity' => (int)$data['quantity']]]],
                );
            });
        } else {
            return DB::collection('customers')->raw(function ($collection) use ($data, $customer_detail) {
                return $collection->updateOne(
                    ['customer_id' => $customer_detail['customer_id'], 'cart.product_id' => $data['product_id']],
                    ['$set' => ['cart.$.pQuantity' => (int)$data['quantity']]],
                );
            });
        }
    }

    public function m_removeFromCart($product_id, $id)
    {
        return DB::collection('customers')->raw(function ($collection) use ($product_id, $id) {
            return $collection->updateOne(
                ['customer_id' => $id],
                ['$pull' => ['cart' => ['product_id' => $product_id]]],
            );
        });
    }

    public function m_getCartProducts($id)
    {
        return DB::collection('customers')->raw(function ($collection) use ($id) {
            return $collection->aggregate(
                [
                    ['$match' => ['customer_id' => $id]],
                    [
                        '$lookup' => [
                            'from' => 'products',
                            'localField' => 'cart.product_id',
                            'foreignField' => 'product_id',
                            'as' => 'Cartproducts'

                        ]
                    ],
                    ['$project' => ['Cartproducts' => 1, 'cart' => 1, '_id' => 0, 'TotalAmount' => ['$sum' => '$Cartproducts.price']]],
                    ['$unwind' => '$Cartproducts'],
                    ['$unwind' => '$cart'],
                    ['$match' => ['$expr' => ['$eq' => ['$cart.product_id', '$Cartproducts.product_id']]]],
                    ['$group' => ['_id' => null, 'GrandTotal' => ['$sum' => ['$multiply' => ['$cart.pQuantity', '$Cartproducts.price']]], 'products' => ['$push' => '$Cartproducts.product_id']]],
                    [
                        '$lookup' => [
                            'from' => 'products',
                            'localField' => 'products',
                            'foreignField' => 'product_id',
                            'as' => 'Cartproducts'

                        ]
                    ],
                    ['$project' => ['Cartproducts.quantity' => 0, 'products' => 0]]

                ],


            )->toArray();
        });
    }
    public function m_buy($customer_detail)
    {

        $products = $customer_detail['cart'];
        if (count($products) > 0) {
            foreach ($products as $key => $value) {
                $product = DB::collection("products")->where('product_id', $value['product_id'])->first();
                if ($value['pQuantity'] > $product['quantity']) {
                    return $product['name'] . " quantity is less then your demand quantity";
                } else {
                    // Database Transaction
                    $session = DB::getMongoClient()->startSession();
                    $session->startTransaction();
                    try {
                        DB::collection("products")->where('product_id', $value['product_id'])->decrement('quantity', $value['pQuantity']);
                        DB::collection('customers')->where('_id', $customer_detail['_id'])->pull('cart', $value);

                        $session->commitTransaction();
                    } catch (Exception $e) {
                        $session->abortTransaction();
                    }
                }
            }

            return response('Product bought successfully', 200);
        } else return response("No product to buy, try adding some products to the cart", 400);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
