<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//Models
use App\Models\{
    User
};
class AuthController extends Controller
{
        /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->error(__('auth.failed'), 401);
            }
            // Get the authenticated user.
            $user = auth()->user();

            $token = JWTAuth::fromUser($user);
            return $this->success([
                'token' => $token,
            ]);
        } catch (JWTException $e) {
            return $this->error('No pudimos crear el token de autenticación', 500);
        }
    }

    /**
     * Registers a new user in the system.
     *
     * This method handles the registration process for a new user. It validates the input data,
     * creates a new user record in the database, and sends a confirmation email to the user.
     *
     * @param array $userData An associative array containing user information such as 'name', 'email', and 'password'.
     * @return bool Returns true if the registration is successful, false otherwise.
     * @throws InvalidArgumentException If the provided user data is invalid.
     * @throws RuntimeException If there is an error during the registration process.
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
    
            if ($validator->fails()) {
                return $this->error('Datos inválidos', 400,$validator->errors());
            }
    
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
    
            $token = JWTAuth::fromUser($user);
    
            return $this->success(
                [
                'user'=>$user,
                'token'=>$token
                ]
            );
        }catch(\Exception $e){
            return $this->error($e->getMessage(), 500);
        }
    }//register

    /**
     * Retrieve the authenticated user based on the provided JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     * 
     * Responses:
     * - 200: Successfully retrieved the authenticated user.
     * - 400: Invalid token provided.
     * - 404: User not found.
     */
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->error(__('auth.not_found'), 404);
            }
        } catch (JWTException $e) {
            return $this->error(__('auth.invalid_token'), 400);
        }

        return $this->success([compact('user')]);
    }

    /**
     * Log the user out by invalidating the JWT token.
     *
     * This method invalidates the current JWT token, effectively logging the user out.
     * It then returns a success response with a message indicating that the logout was successful.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the logout status.
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->success([],200,__('auth.success_logged_out'));
    }
}
