<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/comment', [
  'uses' => 'CommentController@postComment',
  // 'middleware' => 'auth.jwt'
]);

Route::get('/comments', [
  'uses' => 'CommentController@getComments'
]);

Route::put('/comment/{id}', [
  'uses' => 'CommentController@putComment',
  // 'middleware' => 'auth.jwt'
]);

Route::delete('/comment/{id}', [
  'uses' => 'CommentController@deleteComment',
  // 'middleware' => 'auth.jwt'
]);

Route::get('/one-comment/{id}', [
  'uses' => 'CommentController@oneComment',
  // 'middleware' => 'auth.jwt'
]);
