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

$router->group(['middleware' =>
    [
        //'throttle:1,1',
        //'throttle:5,60'
    ]
], function() use ($router) {
    $router->get('sendCode', 'EmailController@sendCode');
});
