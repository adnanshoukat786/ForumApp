<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//echo 'here'; exit;
Auth::routes();
Route::post('/dologin', 'UserController@doLogin'); 
Route::get('/checkuserandgetPost', 'HomeController@checkuserandgetPost');
Route::POST('/addPost', 'HomeController@addpost');
Route::POST('/updatepost', 'HomeController@updatepost');
Route::get('/getposts', 'HomeController@getPosts');
Route::get('/topic/{id}', 'HomeController@singlePosts');
Route::POST('/commentPost', 'CommentController@commentPost');


Route::get('/', 'HomeController@index')->name('home');



