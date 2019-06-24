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


Route::get('/', 'DiaryController@index')->name('diary.index');
//囲んだルートは、ログインしてない場合、表示できなくなります。
//ユーザーしかすることができないもの

Route::group(['middleware' => 'auth'], function() {
Route::get('diary/create', 'DiaryController@create')->name('diary.create'); // 投稿画面
Route::post('diary/create', 'DiaryController@store')->name('diary.create'); // 保存処理

Route::get('diary/{diary}/edit', 'DiaryController@edit')->name('diary.edit'); // 編集画面
Route::put('diary/{diary}/update', 'DiaryController@update')->name('diary.update'); //更新処理

//{} -> ワイルドカード・・・なんでもいい値を入れたいときにこのカードを使う
Route::delete('diary/{diary}/delete', 'DiaryController@destroy')->name('diary.destroy'); // 削除処理

Route::post('diary/{id}/like', 'DiaryController@like');
Route::post('diary/{id}/dislike', 'DiaryController@dislike');


});
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
