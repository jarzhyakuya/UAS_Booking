<?php

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

$router->get('/hello-lumen', function () use ($router) {
    return "<h1>Lumen</h1><p>Hi good developer, thanks for using Lumen</p>";
});

$router->get('/hello-lumen/{name}', function ($name) {
    return "<h1>Lumen</h1><p>Hi <b>" . $name . "</b>, thanks for using Lumen</p>";
});

$router->get('/scores', ['middleware' => 'login', function () {
    return "<h1>Selamat</h1><p>Nilai anda 100</p>";
}]);

$router->get('/users', 'UsersController@index');

$router->group(['prefix' => 'user'], function() use ($router){
    //buat user ajah
    $router->post('/register', 'UserController@register');
    $router->post('/login', 'UserController@login');
});

$router->group(['middleware' => ['auth']], function($router){
    
    $router->group(['prefix' => 'meja'], function() use ($router){
        $router->post('/', 'MejaController@store');
        $router->get('/', 'MejaController@index');
        $router->get('/{id}', 'MejaController@show');
        $router->delete('/{id}', 'MejaController@destroy');
    });
    
    //buat admin
    $router->group(['prefix' => 'user'], function() use ($router){
        $router->get('/{id}', 'UserController@show');
        $router->put('/{id}', 'UserController@update');
    });

});

