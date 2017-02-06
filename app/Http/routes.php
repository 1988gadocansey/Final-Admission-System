<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

Route::group(['middleware' => ['web']], function () {
 Route::auth();
    Route::get('/', function () {
        return view('auth/login');
    })->middleware('guest');
    
    
    Route::get('dashboard', 'FormController@index');
    Route::get('/upload/photo', 'FormController@showPictureUpload');
    Route::post('/upload/photo', 'FormController@uploadPicture');
    Route::get('/form/step2', 'FormController@step2');
    Route::post('form/step2', 'FormController@store');
    //Route::get('/form/step3', 'FormController@createGrades');
    Route::match(array("get", "post"),'/form/step3', 'FormController@step3');
    Route::get('form/academic/grades', 'FormController@createGrades');
    
    Route::post('form/academic/grades', 'FormController@step4');
     
    Route::delete('delete_grade','FormController@destroyGrade');
    Route::get('/form/preview', 'FormController@preview');
    Route::get('/form/print', 'FormController@preview');
    Route::get('/form/completed', 'FormController@finanlize');
    Route::get('/form/letter', 'FormController@letter');
    Route::get('/generate', 'FormController@generateAccounts');
     

   
});

 
