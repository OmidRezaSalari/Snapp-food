<?php

namespace Authenticate\Controllers\V1;

use App\Http\Controllers\Controller;
use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Requests\UserLoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    /**
     * login user
     *
     * @param UserLoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        try {

            if (!$token = AuthFacade::attempt($request->validated())) {

                return ResponderFacade::inputsIsInvalid();
            }
            return ResponderFacade::loggedIn($token);
        } catch (Exception $exception) {

            ResponderFacade::sendServerError($$exception->message)->throwResponse();
        }
    }
}
