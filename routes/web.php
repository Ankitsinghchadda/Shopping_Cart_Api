<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// Shopping Cart


// Customer Collection
$router->post('api/addToCart', 'ShoppingController@addToCart');
$router->delete('api/removeFromCart', 'ShoppingController@removeFromCart');
$router->get('api/myCart', 'ShoppingController@getCartProducts');
$router->get('api/buy', 'ShoppingController@buy');
$router->post('api/updateDetails', 'ShoppingController@updateCustomerDetails');




// Product Collection
$router->get('products', 'ProductController@getAllProducts');
$router->post('filterProducts', 'ProductController@filterProducts');
$router->post('addProduct', 'ProductController@addProduct');
$router->delete('deleteProduct', 'ProductController@deleteProduct');
$router->put('updateProduct', 'ProductController@updateProductDetail');


$router->post('api/register', ['uses' => 'AuthController@register']);
$router->post('api/login', ['uses' => 'AuthController@login']);
$router->post('api/logout', ['uses' => 'AuthController@logout']);
$router->post('api/refresh', ['uses' => 'AuthController@refresh']);
$router->post('api/me', ['uses' => 'AuthController@me']);



// Carbon Library
$router->get('carbonDate', 'CarbonController@index');


$router->post('sql/addProduct', 'ProductController@addProductSQL');
$router->get('sql/products', 'ProductController@getProductSQL');

// SQL Queries in lumen
$router->get('advanceSQL', 'SQLController@index');
