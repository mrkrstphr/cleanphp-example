<?php

Route::get('/', 'DashboardController@indexAction');

Route::get('/customers', 'CustomersController@indexAction');
Route::match(['get', 'post'], '/customers/new', 'CustomersController@newOrEditAction');
Route::match(['get', 'post'], '/customers/edit/{id}', 'CustomersController@newOrEditAction');
