<?php

namespace Authenticate\Controllers\V1;

use App\Http\Controllers\Controller;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Repositories\User\UserProviderFacade;
use Authenticate\Requests\UserRegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    /**
     * Register new user
     *
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            
            $userRegistered = UserProviderFacade::create($request->validated());

            return ResponderFacade::userRegistered($userRegistered);
        } catch (Exception $exception) {

            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }
    }
}
