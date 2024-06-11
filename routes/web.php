<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PusherController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;




/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
| */



// Home
Route::redirect('/', '/login');

// Cards
Route::controller(CardController::class)->group(function () {
    //Route::get('/cards', 'list')->name('cards'); //quando entro na página cards, chama o método list do CardController
    Route::get('/cards/{id}', 'show');
    Route::get('/cards/{searchQuery?}','list')->name('cards');
    
});

// Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions/{id}', 'show')->name('question.show');
    Route::get('/questions/{searchQuery?}', 'list')->name('questions');
    Route::get('/personalQuestions','showPersonalQuestions');
    Route::post('/questions/{questionId}/upvote', 'upvote');
    Route::post('/questions/{questionId}/downvote', 'downvote');
     
});

// Users
Route::controller(UserController::class)->group(function () {
    Route::get('/personalPage', 'showPersonalPage');
    Route::get('/users/{id}', 'showUser')->name('user.show');
    Route::get('/users/showAnUser/{answerId}', 'showUserFromAnswers')->name('user.showFromAnswers');
     
    Route::get('/users/{searchQuery?}', 'list')->name('users');
    Route::post('/users/{userId}/follow', 'follow');
    Route::post('/users/{userId}/unfollow', 'unfollow');

});


// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});

Route::controller(QuestionController::class)->group(function () {
    Route::post('/api/questions/createQuestion', 'create');// create question 
    Route::delete('/api/questions/{question_id}', 'delete');
}); 

Route::controller(AnswerController::class)->group(function () {
    Route::put('/api/questions/{question_id}', 'create');
   
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login'); // This route is called when the user visits the login page. It calls the showLoginForm method on the LoginController.
    Route::post('/login', 'authenticate'); // This route is called when the user submits the login form. It calls the authenticate method on the LoginController.
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

//Chat 
Route::controller(PusherController::class)->group(function () {
    Route::get('/chat', 'openChat');
    Route::post('/chat/broadcast', 'broadcast');
    Route::post('/chat/receive', 'receive');
});
 