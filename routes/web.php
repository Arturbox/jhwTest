<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->post('update', 'TreasuryController@importOrUpdateSdnEntities');
$router->get('state', 'TreasuryController@sdnEntitiesState');
$router->get('get_names', 'TreasuryController@sdnEntitiesNames');
