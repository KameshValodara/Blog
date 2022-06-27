<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;


class UserController extends Controller
{
public $successStatus = 200;


/**
 * @OA\Post(
 *    path="/api/login",
 *    summary="Login",
 *    description="Login Page",
 *    tags={"Login"},
 *    @OA\Parameter(
 *      name="email",
 *      @OA\Property(property="email", type="string", pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$", format="email", example="test@gmail.com"),
 *      in="query",
 *      description="Provide your Email",
 *      required=true,
 *    ),
 *    @OA\Parameter(
 *      name="password",
 *      in="query",
 *      description="Provide your password",
 *      required=true,
 *    ),
 *    @OA\Response(
 *      response=200,
 *      description="OK",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *      )
 *    )
 * ),
*/


public function login(){
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        return response()->json(['success' => $success], $this-> successStatus);
    }
    else{
        return response()->json(['error'=>'Unauthorised'], 401);
    }
}


/**
 * @OA\Post(
 *    path="/api/register",
 *    summary="Register",
 *    description="Registration Page",
 *    tags={"Register"},
 *    @OA\RequestBody(
 *          description="Input data format",
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                      @OA\Property(
 *                          property="name",
 *                          description="name",
 *                          type="string"
 *                      ),
 *                      @OA\Property(
 *                          property="email",
 *                          description="Email",
 *                          type="string",
 *                      ),
 *                      @OA\Property(
 *                          property="password",
 *                          description="Password",
 *                          type="string",
 *                      ),
 *                      @OA\Property(
 *                          property="c_password",
 *                          description="Confirm Password",
 *                          type="string",
 *                      ),
 *              )
 *          )
 *     ),
 *   @OA\Response(
*          response="200",
*          description="Registration Example",
*          @OA\JsonContent(
*              type="object",
*              @OA\Property(
*                  type="string",
*                  description="token",
*                  property="token"
*              ),
*              @OA\Property(
*                  property="name",
*              )
*          )
*     ),
* ),
*/
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'c_password' => 'required|same:password',
    ]);
    if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] =  $user->createToken('MyApp')-> accessToken;
    $success['name'] =  $user->name;
    return response()->json(['success'=>$success], $this-> successStatus);
}


/**
 * @OA\Get(
 *    path="/api/details",
 *    summary="Details",
 *    description="Detail Page",
 *    tags={"Details"},
 *    security={{"passport":{}}},
 *    @OA\Response(
 *      response=200,
 *      description="OK",
 *      @OA\MediaType(
 *          mediaType="application/json",
 *      )
 *    )
 * ),
 */
public function details()
{
    $user = Auth::user();
    return response()->json(['success' => $user], $this-> successStatus);
}

}
