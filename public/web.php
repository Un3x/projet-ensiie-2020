<?php
/***************************************************************************
 * On définit toutes les routes ici !
 * Attention pour les paramètres, l'ordre compte !
 ***************************************************************************/

use App\Core\Blade;
use App\Core\Route;

Route::get('/', 'App\Controllers\HomeController@handleHome')->name('home');

Route::get('/profil', 'App\Controllers\ProfileController')->middleware('forUsers')->name('myProfile');
Route::get('/profil/{id}', 'App\Controllers\ProfileController')->name('profile');
Route::get('/creation', function(){ return Blade::create('pages.signup'); })->name('register');

Route::get('/vin/nouveau', 'App\Controllers\WineController@handleNewPage')->middleware('forUsers')->name('wineAddPage');
Route::get('/vin/{id}', 'App\Controllers\WineController@handleExistingPage')->name('winePage');
Route::get('/vin/{id}/edition', 'App\Controllers\WineController@handleExistingEditPage')->middleware('forUsers')->name('wineEditPage');
Route::get('/domaine/{id}', 'App\Controllers\DomainController@handlePage')->name('domainPage');
Route::get('/type/{id}', 'App\Controllers\TypeController@handlePage')->name('typePage');
Route::get('/annee/{id}', 'App\Controllers\YearController@handlePage')->name('yearPage');

Route::get('/recherche/{action}', 'App\Controllers\SearchController@handleSearch')->name('search');

/*******
 *    Les routes d'API
 */
Route::post('/profil/{id}', 'App\Controllers\API\ProfileAPIController@handleEdit')->middleware('forUsers')->name('profileAPI');
Route::delete('/profil/{id}', 'App\Controllers\API\ProfileAPIController@handleDelete')->middleware('forUsers')->name('deleteProfileAPI');
Route::put('/user', 'App\Controllers\API\UserAPIController@handleRegister')->name('registerAPI');
Route::post('/user/login', 'App\Controllers\API\UserAPIController@handleLogin')->name('loginAPI');
Route::get('/user/logout', 'App\Controllers\API\UserAPIController@handleLogout')->name('logoutAPI');

Route::post('/comments/{id}/like', '\App\Controllers\API\CommentsAPIController@handleLikes')->name('commentsLike');
Route::delete('/comments/{id}', '\App\Controllers\API\CommentsAPIController@handleDelete')->name('deleteCommentAPI');
Route::post('/comments/new', '\App\Controllers\API\CommentsAPIController@handlePostComment')->name('commentsPost');
Route::post('/wines/{id}/like', 'App\Controllers\WineController@handleWineLike')->name('winesLike');

Route::post('/wines/new', 'App\Controllers\API\WineAPIController@handleEditAndNew')->middleware('forUsers')->name('winesNewAPI');
Route::post('/wines/{id}', 'App\Controllers\API\WineAPIController@handleEditAndNew')->middleware('forUsers')->name('winesEditAPI');
Route::delete('/wines/{id}', 'App\Controllers\API\WineAPIController@handleDelete')->middleware('forUsers')->name('winesDeleteAPI');

Route::get('/search/domain', '\App\Controllers\API\SearchAPIController@handleDomain')->name('domainSearch');
Route::get('/search/type', '\App\Controllers\API\SearchAPIController@handleType')->name('typeSearch');
Route::get('/search/year', '\App\Controllers\API\SearchAPIController@handleYear')->name('yearSearch');

Route::post('/search/{action}', '\App\Controllers\SearchController@handleResults')->name('searchAPI');