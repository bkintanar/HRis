<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers\Auth;

use Dingo\Api\Facade\API;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Navlink;
use HRis\Api\Eloquent\User;
use HRis\Api\Requests\UserRequest;
use HRis\Api\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function me(Request $request)
    {
        $data = JWTAuth::parseToken()->authenticate();

        return $this->item(User::findOrFail($data->id), new UserTransformer);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function sidebar()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $sidebar = Navlink::sidebar($user);

        return response()->json(compact('sidebar'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function validateToken()
    {
        // Our routes file should have already authenticated this token, so we just return success here
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function register(UserRequest $request)
    {
        $newUser = [
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }

    /**
     * Deactivate active user.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function signout()
    {
        $response = [];
        try {

            if (JWTAuth::parseToken()->invalidate()) {
                $response['text'] = 'Signed out';
                $response['code'] = 200;
            } else {
                $response['text'] = 'Cannot sign out';
                $response['code'] = 417;
            }
        } catch (JWTException $e) {
            $response['text'] = $e->getMessage();
            $response['code'] = $e->getCode();
        } catch (\Exception $e) {
            $response['text'] = $e->getMessage();
            $response['code'] = $e->getCode();
        }

        return response()->json($response);
    }
}
