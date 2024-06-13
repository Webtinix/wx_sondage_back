<?php

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InfusioController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ClassLangController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\AttributeLangController;
use App\Http\Controllers\GroupeAttributeController;
use App\Http\Controllers\InfusioDashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::get('/users/create_default', [UserController::class, 'createUserDefault']);
Route::post('/login', [AuthController::class, 'login']);
Route::prefix('v1')->group(function() {

Route::middleware('auth:api')->group(function() {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users/{id?}', [UserController::class, 'get']);
    Route::put('/users/{id}', [UserController::class, 'put']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::get('/users/delete_all', [UserController::class, 'deleteAllUser']);Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::controller(AppController::class)->group(function () {
    Route::get('/formations/{id?}', 'get');
    Route::get('/utilisateurs/{id?}', 'utilisateurs');
    Route::get('/debug', 'debug');
    Route::post('/debug', 'debug');
})->middleware('powerbi:api');

// Route::get('/{company}/{lang}/{class}/0', [InfusioController::class, 'get'])->where('class', 'sondage-.+');
// Route::get('/{company}/{lang}/{class}/total_sondage', [InfusioController::class, 'getTotalSondage'])->where('class', 'sondage-.+');
// Route::get('/{company?}/{lang?}/{class?}/{instance_id?}', [InfusioController::class, 'getsondage'])->where(['class' => 'sondage-.+','instance_id' => '[1-9][0-9]*']);
// Route::post('/{company?}/{lang?}/{class}/{instance_id?}', [InfusioController::class, 'postSondage'])->where('class', 'sondage-.+');


    Route::get('infusio/infusioadmin/classes/{tech_name?}/{groups?}/{group_attribute?}/{attribute?}/{attribute_id?}', [ClasseController::class, 'get']);
    Route::delete('infusio/infusioadmin/classes/{id}', [ClasseController::class, 'delete']);
    Route::put('infusio/infusioadmin/classes/{id}', [ClasseController::class, 'put']);
    Route::post('infusio/infusioadmin/classes', [ClasseController::class, 'post']);

    Route::get('infusio/infusioadmin/attributes/{id?}', [AttributeController::class, 'get']);
    Route::delete('infusio/infusioadmin/attributes/{id}', [AttributeController::class, 'delete']);
    Route::put('infusio/infusioadmin/attributes/{id}', [AttributeController::class, 'put']);
    Route::post('infusio/infusioadmin/attributes', [AttributeController::class, 'post']);

    // liste des routes pour le crud des companys
    Route::get('infusio/infusioadmin/companys/{id?}', [CompanyController::class, 'get']);
    Route::delete('infusio/infusioadmin/companys/{id}', [CompanyController::class, 'delete']);
    Route::put('infusio/infusioadmin/companys/{id}', [CompanyController::class, 'put']);
    Route::post('infusio/infusioadmin/companys', [CompanyController::class, 'post']);

    // liste des routes pour le crud des components
    
    Route::get('infusio/infusioadmin/component/{id?}', [ComponentController::class, 'get']);
    Route::delete('infusio/infusioadmin/component/{id}', [ComponentController::class, 'delete']);
    Route::put('infusio/infusioadmin/component/{id}', [ComponentController::class, 'put']);
    Route::post('infusio/infusioadmin/component', [ComponentController::class, 'post']);

    // liste des routes pour le crud des Langs
    
    Route::get('infusio/infusioadmin/lang/{id?}', [LangController::class, 'get']);
    Route::delete('infusio/infusioadmin/lang/{id}', [LangController::class, 'delete']);
    Route::put('infusio/infusioadmin/lang/{id}', [LangController::class, 'put']);
    Route::post('infusio/infusioadmin/lang', [LangController::class, 'post']);

    // liste des routes pour le crud des attributesLangs

    Route::get('infusio/infusioadmin/attributes/lang/{id?}', [AttributeLangController::class, 'get']);
    Route::delete('infusio/infusioadmin/attributes/lang/{id}', [AttributeLangController::class, 'delete']);
    Route::put('infusio/infusioadmin/attributes/lang/{id}', [AttributeLangController::class, 'put']);
    Route::post('infusio/infusioadmin/attributes/lang', [AttributeLangController::class, 'post']);

    // liste des routes pour le crud des classesLangs

    Route::get('infusio/infusioadmin/classes/lang/{id?}', [ClassLangController::class, 'get']);
    Route::delete('infusio/infusioadmin/classes/lang/{id}', [ClassLangController::class, 'delete']);
    Route::put('infusio/infusioadmin/classes/lang/{id}', [ClassLangController::class, 'put']);
    Route::post('infusio/infusioadmin/classes/lang', [ClassLangController::class, 'post']);

    // liste des routes pour le crud des groupeAttributes

    Route::get('infusio/infusioadmin/groupeAttributes/{id?}', [GroupeAttributeController::class, 'get']);
    Route::delete('infusio/infusioadmin/groupeAttributes/{id}', [GroupeAttributeController::class, 'delete']);
    Route::put('infusio/infusioadmin/groupeAttributes/{id}', [GroupeAttributeController::class, 'put']);
    Route::post('infusio/infusioadmin/groupeAttributes', [GroupeAttributeController::class, 'post']);
    
    # Authentificate routes

    Route::controller(InfusioController::class)->group(function () {
        #get
        Route::get('/{company}/{lang}/{class}/{instance?}', 'getClass');
        # POST
        Route::post('/{company}/{lang}/{class}/{instance_id?}', 'post');
        # PUT
        Route::put('/{company?}/{lang?}/{class} /{instance?}', 'put');
        # DELETE
        Route::delete('/{company?}/{lang?}/{class?}/{instance?}', 'delete');

        //inscription

        #get
        // Route::get('/{company}/{lang}/inscription/{instance?}', 'inscription');
        // # POST
        // Route::post('/{company}/{lang}/inscription/{instance_id?}', 'post_inscription');
        // # PUT
        // Route::put('/{company?}/{lang?}/inscription/{instance?}', 'put_inscription');
        // # DELETE
        // Route::delete('/{company?}/{lang?}/{class?}/{instance?}', 'delete_inscription');
    });



});
