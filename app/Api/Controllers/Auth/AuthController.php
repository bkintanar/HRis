<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Auth;

use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Navlink;
use HRis\Api\Eloquent\User;
use HRis\Api\Requests\UserRequest;
use HRis\Api\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
        $data = [];
        try {
            $data = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            dd('test');
        }

        return $this->item(User::findOrFail($data->id), new UserTransformer());
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function token()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            throw new BadRequestHttpException('Token not provided');
        }
        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }

        return $this->responseAPI(201, SUCCESS_TOKEN_REFRESH_MESSAGE, compact('token'));
    }

    /**
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function sidebar()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $sidebar = Navlink::sidebar($user);

        return $this->responseAPI(200, SUCCESS_RETRIEVE_SIDEBAR_MESSAGE, compact('sidebar'));
    }

    /**
     * Authenticates guest user by logging in.
     *
     * @SWG\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Authenticates guest user by logging in.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"token", "status_code"},
     *             @SWG\Property(property="token", type="string"),
     *             @SWG\Property(property="status_code", type="integer", default=201, description="Status code from server"),
     *             @SWG\Property(property="message", type="string", default="Token successfully created."),
     *         )
     *     ),
     *     @SWG\Response(response="401", description="Invalid credentials",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="invalid_credentials"),
     *             @SWG\Property(property="status_code", type="integer", default=401, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="422", description="Could not create token",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="could_not_create_token"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Registered user's email address",
     *         required=true,
     *         type="string",
     *         default="bertrand.kintanar@gmail.com",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Registered user's password",
     *         required=true,
     *         type="string",
     *         default="retardko",
     *     ),
     * )
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = array_filter($request->only('email', 'password'));

        $claims = ['company' => 'HRis'];

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials, $claims)) {
                return $this->responseAPI(401, 'invalid_credentials');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->responseAPI(422, 'could_not_create_token');
        } catch (Exception $e) {
            return $this->responseAPI(422, $e->getMessage());
        }

        // all good so return the token
        return $this->responseAPI(201, SUCCESS_TOKEN_CREATED_MESSAGE, compact('token'));
    }

    /**
     * @param UserRequest $request
     *
     * @return \Dingo\Api\Http\Response
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

        return $this->responseAPI(201, SUCCESS_TOKEN_CREATED_MESSAGE, compact('token'));
    }

    /**
     * Logout currently authenticated user.
     *
     * @SWG\Get(
     *     path="/logout",
     *     tags={"Authentication"},
     *     summary="Logout currently authenticated user.",
     *     @SWG\Response(response="200", description="Signed out",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="signed_out"),
     *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="400", description="Token not provided",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Token not provided"),
     *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object"),
     *         )
     *     ),
     *     @SWG\Response(response="417", description="Cannot sign out",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="cannot_sign_out"),
     *             @SWG\Property(property="status_code", type="integer", default=417, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Response(response="422", description="Could not create token",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="could_not_create_token"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="JWT Token",
     *         required=true,
     *         type="string",
     *         default="Bearer ",
     *         @SWG\Items(type="string")
     *     ),
     * )
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function logout()
    {
        $response = [];
        try {
            if (JWTAuth::parseToken()->invalidate()) {
                $response['message'] = 'signed_out';
                $response['status_code'] = 200;
            } else {
                $response['message'] = 'cannot_sign_out';
                $response['status_code'] = 417;
            }
        } catch (JWTException $e) {
            $response['message'] = $e->getMessage();
            $response['status_code'] = 422;
        }

        return $this->responseAPI($response['status_code'], $response['message']);
    }
}
