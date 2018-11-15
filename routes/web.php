<?php

use App\Todo;
use Illuminate\Http\Request;

//
Route::get('/', 'HomeController@index')->name('home');

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('google.login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

//Route::get('/', function () {
//    	$todos = Todo::orderBy('created_at', 'asc')->get();
//
//	return view('todo', [
//		'todos' => $todos
//	]);
//});

Route::post('/todo', function(Request $request){
	$validator = Validator::make($request->all(), [
		'name' => 'required|max:255',
	]);

	if($validator->fails()){
		return redirect('/')
			->withInput()
			->withErrors($validator);
	}

	$todo = new Todo;
	$todo->name = $request->name;
	$todo->save();

	return redirect('/');

});

Route::delete('/todo/{todo}', function(Todo $todo){
	$todo->delete();

	return redirect('/');
});

Auth::routes();
