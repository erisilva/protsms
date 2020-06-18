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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin','namespace' => 'Auth'],function(){
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->namespace('Admin')->group(function () {
	/*  Operadores */
	// nota mental :: as rotas extras devem ser declaradas antes de se declarar as rotas resources
    Route::get('/users/password', 'ChangePasswordController@showPasswordUpdateForm')->name('users.password');
	Route::put('/users/password/update', 'ChangePasswordController@passwordUpdate')->name('users.passwordupdate');
    Route::get('/users/export/csv', 'UserController@exportcsv')->name('users.export.csv');
	Route::get('/users/export/pdf', 'UserController@exportpdf')->name('users.export.pdf');
    Route::get('/users/autocomplete', 'UserController@autocomplete')->name('users.autocomplete');
    Route::resource('/users', 'UserController');

	/* Permissões */
    Route::get('/permissions/export/csv', 'PermissionController@exportcsv')->name('permissions.export.csv');
	Route::get('/permissions/export/pdf', 'PermissionController@exportpdf')->name('permissions.export.pdf');
    Route::resource('/permissions', 'PermissionController');

    /* Perfis */
    Route::get('/roles/export/csv', 'RoleController@exportcsv')->name('roles.export.csv');
    Route::get('/roles/export/pdf', 'RoleController@exportpdf')->name('roles.export.pdf');
    Route::resource('/roles', 'RoleController');
});

/* Setores */
Route::get('/setores/export/csv', 'SetorController@exportcsv')->name('setores.export.csv');
Route::get('/setores/export/pdf', 'SetorController@exportpdf')->name('setores.export.pdf');
Route::get('/setores/autocomplete', 'SetorController@autocomplete')->name('setores.autocomplete');
Route::resource('/setores', 'SetorController');

/* Tipificação dos protocolos */
Route::get('/protocolotipos/export/csv', 'ProtocoloTipoController@exportcsv')->name('protocolotipos.export.csv');
Route::get('/protocolotipos/export/pdf', 'ProtocoloTipoController@exportpdf')->name('protocolotipos.export.pdf');
Route::resource('/protocolotipos', 'ProtocoloTipoController');

/* PROTOCOLOS */
## cooncluir um protocolo
Route::post('/protocolos/concluir/{id}', 'ProtocoloController@concluir')->name('protocolos.concluir');
## demais rotas
Route::get('/protocolos/export/csv', 'ProtocoloController@exportcsv')->name('protocolos.export.csv');
Route::get('/protocolos/export/pdf', 'ProtocoloController@exportpdf')->name('protocolos.export.pdf');
Route::get('/protocolos/export/pdf/{id}/individual', 'ProtocoloController@exportpdfindividual')->name('protocolos.export.pdf.individual');
Route::resource('/protocolos', 'ProtocoloController');

/*ANEXOS DOS PROTOCOLOS*/
Route::resource('/protocoloanexos', 'ProtocoloAnexoController')->only(['store', 'destroy',]);

/*NOTAS DOS PROTOCOLOS*/
Route::resource('/protocolonotas', 'ProtocoloNotaController')->only(['store', 'destroy',]);

/* TRAMITAÇÃO DOS PROTOCOLOS */
Route::resource('/protocolotramitacoes', 'ProtocoloTramitacaoController');
