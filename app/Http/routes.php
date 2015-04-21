<?php

Route::get('/', 'DashboardController@indexAction');

Route::get('/customers', 'CustomersController@indexAction');
Route::match(['get', 'post'], '/customers/new', 'CustomersController@newOrEditAction');
Route::match(['get', 'post'], '/customers/edit/{id}', 'CustomersController@newOrEditAction');

Route::get('/orders', 'OrdersController@indexAction');
Route::match(['get', 'post'], '/orders/new', 'OrdersController@newAction');
Route::get('/orders/view/{id}', 'OrdersController@viewAction');
