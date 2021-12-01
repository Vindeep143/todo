<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/** APIs */
$router->post('/user/authenticate', 'UserController@authenticate');
$router->post('/user', 'UserController@create');
$router->get('/user/notes', 'NotesController@getAllNotesForUser');
$router->post('/note', 'NotesController@create');
$router->get('/note/{id}', 'NotesController@getNoteById');
$router->delete('/note/{id}', 'NotesController@deleteNoteById');
$router->put('/note/completed/{id}', 'NotesController@setCompleted');
$router->put('/note/incomplete/{id}', 'NotesController@sestIncomplete');
$router->get('/admin/notes/{id}', 'AdminController@getAllNotes');

/** Views */
$router->get('/dashboard', 'ViewController@loadDashboard');
$router->get('/', function ()  {
    return view('home');
});
$router->get('/login', function ()  {
    return view('login');
});
$router->get('/register', function ()  {
    return view('register');
});

