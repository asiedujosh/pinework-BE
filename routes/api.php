<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\bookTypeController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\classController;
use App\Http\Controllers\authorController;
use App\Http\Controllers\questionController;
use App\Enums\TokenAbility;

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

/** One Login Staff */
Route::post('/login', [userController::class, 'login']);

/** Author */
Route::post('/storeAuthor',[authorController::class, 'storeAuthor']);
Route::get('/authorInfo/{id}',[authorController::class, 'getAuthorInfo']);

/** Book Type Routes */
Route::get('/getBookType',[bookTypeController::class, 'index']);
Route::get('/searchBookType', [bookTypeController::class,'searchBookType']);
Route::get('/getAllBookType',[bookTypeController::class, 'getAllBookType']);
Route::post('/storeBookType',[bookTypeController::class, 'storeBookType']);
Route::put('/updateBookType/{id}',[bookTypeController::class, 'updateBookType']);
Route::delete('/deleteBookType/{id}',[bookTypeController::class, 'deleteBookType']);
/** End Book Type Routes */

/** Class Routes */
Route::get('/getClasses',[classController::class, 'index']);
Route::get('/searchClasses', [classController::class,'searchClasses']);
Route::get('/getAllClasses',[classController::class, 'getAllClasses']);
Route::post('/storeClasses',[classController::class, 'storeClasses']);
Route::put('/updateClasses/{id}',[classController::class, 'updateClasses']);
Route::delete('/deleteClasses/{id}',[classController::class, 'deleteClasses']);
/** End Class Routes */


/** Books Routes */
Route::get('/getBook',[bookController::class, 'index']);
Route::get('/getAuthorBooks',[bookController::class, 'getAuthorBooks']);
Route::get('/searchBook', [bookController::class,'searchBook']);
Route::get('/countBooksNotPublishedByAuthor/{id}', [bookController::class,'countBooksNotPublishedByAuthor']);
Route::get('/countBooksPublishedByAuthor/{id}', [bookController::class,'countBooksPublishedByAuthor']);
Route::get('/searchAuthorBook', [bookController::class,'searchAuthorBook']);
Route::post('/storeBook',[bookController::class, 'storeBook']);
Route::put('/updateBook/{id}',[bookController::class, 'updateBook']);
Route::put('/updateBookStatus/{id}',[bookController::class, 'updateBookStatus']);
Route::delete('/deleteBook/{id}',[bookController::class, 'deleteBook']);
/** End Books Routes **/

/** Pages Routes */
Route::get('/getBookPage',[pageController::class, 'getBookPage']);
Route::get('/searchPage', [pageController::class,'searchPage']);
Route::post('/storePage',[pageController::class, 'storePage']);
Route::put('/updatePage/{id}',[pageController::class, 'updatePage']);
Route::delete('/deletePage/{id}',[pageController::class, 'deletePage']);
/** End Pages */


/** Question Routes */
Route::get('/getQuestions', [questionController:: class, 'index']);
Route::get('/countQuestions', [questionController::class, 'countQuestionsOnPage']);
Route::post('/storeQuestion', [questionController::class, 'storeQuestion']);
Route::put('/updateQuestion/{id}', [questionController::class, 'updateQuestion']);
Route::delete('/deleteQuestion/{id}',[questionController::class, 'deleteQuestion']);
/** End Question Routes */


Route::middleware(['auth:sanctum'])->get('/retrieve', [userController::class, 'getUserDetails']);
Route::post('/logout', [userController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
