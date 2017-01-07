<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

$app->get('/', function() use ($app) {
   return 'client';
});

$app->post('login', function() use($app) {
   $credentials = app()->make('request')->json()->all();
   if (app()->make('request')->input('username')) {
      $credentials = app()->make('request')->input();
   }
   //return ($credentials);
   return $app->make('App\Auth\Proxy')->attemptLogin($credentials);
});

$app->post('refresh-token', function() use($app) {
   return $app->make('App\Auth\Proxy')->attemptRefresh();
});

$app->post('oauth/access-token', function() use($app) {
   return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});


$app->group(['prefix' => 'v1', 'middleware' => 'oauth'], function () use ($app)
 {
 
});


$app->group(['prefix' => 'v1'], function () use ($app) 
{
     $app->get('profile', 'App\Http\Controllers\customerController@show');
   $app->post('register', 'App\Http\Controllers\customerController@store');
   $app->post('facebook_login', 'App\Http\Controllers\facebook@insert');
   $app->post('linkdin_login', 'App\Http\Controllers\facebook@linkdin');
   $app->post('wall', 'App\Http\Controllers\wallController@store');
 
});
$app->group(['prefix' => 'v2'], function () use ($app) 
{
   $app->post('wall', 'App\Http\Controllers\wallController@store');
     // $app->get('profile', 'App\Http\Controllers\customerController@show');

});




