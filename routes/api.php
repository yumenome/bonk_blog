<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryApiController;

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
// all crud here
Route::apiResource('/categories', CategoryApiController::class);

Route::post('/login', function (Request $request) {
    $email = $request->email;
    $password = $request->password;
    if(!$email || !$password){
        return response(['msg' => 'inputs required'], 400);
    }
    $user = User::where("email", $email)->first();
    if($user){
        if(password_verify($password, $user->password)){
            return $user->createToken("api")->plainTextToken;
        }
    }
    return response(['msg' => 'something wrong i can feel it'], 401);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
