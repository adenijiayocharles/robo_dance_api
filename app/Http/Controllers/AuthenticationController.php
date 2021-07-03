<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\ManagerResource;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    /**
     * Creates a new team manager account
     *
     * @param   Request  $request
     * @return  json
     */
    public function register(Request $request)
    {
        // validates incoming data including making sure
        // that email address is unique
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:3,100',
            'email' => 'required|string|email|max:100|unique:managers',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Invalid request', $validator->errors());
        }

        // store manager information in the database
        $manager = Manager::create($validator->validated());

        // generate json token
        $token = JWTAuth::fromUser($manager);

        return $this->sendResponse('Account created successfully', ["manager" => new ManagerResource($manager), "auth_token" => $token]);
    }
}
