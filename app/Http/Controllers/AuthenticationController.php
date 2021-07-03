<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\ManagerResource;
use App\Http\Requests\LoginManagerRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegisterManagerRequest;

class AuthenticationController extends Controller
{
    /**
     * Creates a new team manager account
     *
     * @param   Request  $request
     * @return  json
     */
    public function register(RegisterManagerRequest $request)
    {
        // store manager information in the database
        $manager = Manager::create($request->validated());

        // generate json token
        $token = JWTAuth::fromUser($manager);

        return $this->sendResponse('Account created successfully', 
            [
                "manager" => new ManagerResource($manager), 
                "auth_token" => $token
            ]
        );
    }


    /**
     * Verifies user credentials and generates JWT
     *
     * @param   LoginManagerRequest  $request  [$request description]
     * @return  json
     */
    public function login(LoginManagerRequest $request)
    {
        try {
            $token = JWTAuth::attempt($request->validated());
            if (!$token) {
                return $this->sendError('Invalid credentials');
            }
            return $this->sendResponse('Login successful', 
                [
                    'auth_token' => $token
                ]
            );
        } catch (JWTException $e) {
            return $this->sendError('Unable to generate auth token');
        }
    }
}
