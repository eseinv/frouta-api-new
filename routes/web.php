<?php
//  php -S localhost:8000 -t ./public
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
use Illuminate\Http\Response;

$router->get('/', function () use ($router) {
    return response('hi', 200);
});

$router->post('/login', 'AuthController@authenticate');
$router->post('/register', 'UsersController@createUser');
$router->get('/product', 'ProductsController@showAllProducts');
$router->get('/product/{id}', 'ProductsController@showProduct');


$router->group(['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->get('/user/{id}', 'UsersController@showProfile');
        $router->get('/user', 'UsersController@showAllProfiles');
        $router->patch('/user/{id}', 'UsersController@updateUser');
        $router->delete('/user/{id}', 'UsersController@deleteUser');
        $router->post('/product/create', 'ProductsController@createProduct');
        $router->patch('/product/{id}', 'ProductsController@updateProduct');
        $router->delete('/product/{id}', 'ProductsController@deleteProduct');
        $router->get('/cart', 'CartsController@showAllCarts');
        $router->get('/cart/user/{id}', 'CartsController@showUserCarts');
        $router->get('/cart/{id}', 'CartsController@showCart');
        $router->post('/cart/{id}', 'CartsController@createCart');
        $router->patch('/cart/{id}', 'CartsController@updateCart');
        $router->patch('/cart/user/{id}', 'CartsController@confirmCart');
        $router->delete('/cart/{id}', 'CartsController@deleteCart');
		$router->get('/partner', 'PartnersController@showAllPartners');
		$router->post('/partners/create', 'PartnersController@showPartners');
		$router->patch('/partner/{id}', 'PartnersController@updatePartner');
        $router->delete('/partner/{id}', 'PartnersController@deletePartner');
    });
