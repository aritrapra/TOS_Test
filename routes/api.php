<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\GetTokenController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('myauth')->group(function(){

    //profile routes start

    Route::prefix('profile')->group(function(){

        Route::get('/', [ProfileController::class, 'get']);

        Route::post('update',[ProfileController::class , 'update']);


    });

    //profile routes end



    //article routes for

    Route::prefix('article')->group(function(){

        Route::get('/', [ArticleController::class , 'get'])->middleware('ValidArticle');

        //routes for only writer

        Route::middleware('onlyWriter')->group(function(){

            Route::post('create',[ArticleController::class, 'create']);

            //article owner routes

            Route::middleware(['ValidArticle','ArticleOwner'])->group(function(){

                Route::get('/', [ArticleController::class, 'get']);

                Route::post('update',[ArticleController::class, 'update']);

                Route::post('delete',[ArticleController::class, 'delete']);

                Route::get('comments', [ArticleController::class, 'comments']);

            });

        });

        //routes for only editor

        Route::middleware('onlyEditor')->group(function(){

            Route::get('all',[ArticleController::class, 'all']);

            Route::prefix('comment')->middleware('ValidArticle')->group(function(){

                Route::post('create',[CommentController::class, 'create']);

            });



        });




    });








});



//token or user registration routes start

Route::post('register',[GetTokenController::class, 'register']);

Route::post('login',[GetTokenController::class, 'login']);

//token or user registration routes end
