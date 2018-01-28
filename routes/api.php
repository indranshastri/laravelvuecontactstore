<?php

use Illuminate\Http\Request;
use App\Contact;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function () {
    //get all contacts
    Route::get('contacts', function () {
        return Contact::latest()->orderby('created_at','desc')->get();
    });
    
    //get one contacts
    Route::get('contact/{id}', function ($id) {
        return Contact::findOrFail($id);
    });
    
    //get create contacts
    Route::post('contact/store', function (Request $request) {
        return Contact::create([
            "conctact"=>$request->input(['name']),
            "email"=>$request->input(['email']),
            "phone"=>$request->input(['phone']),
            ]);
    });
    
    //get update contacts
    Route::patch('contact/{id}',function(Request $request,$id){
        Contact::findOrFail($id)->update([
            "conctact"=>$request->input(['name']),
            "email"=>$request->input(['email']),
            "phone"=>$request->input(['phone']),
        ]);
    });

    //get delete contacts
    Route::delete('contact/{id}', function ($id) {
        return Contact::destroy($id);
    });
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
