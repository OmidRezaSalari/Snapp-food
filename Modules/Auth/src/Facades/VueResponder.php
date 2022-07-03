<?php

namespace Authenticate\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VueResponder
{
    const HTTP_SUCCESS_CODE = 200;
    const HTTP_CLIENT_ERROR_CODE = 400;
    const HTTP_SERVER_ERROR_CODE = 500;

    const ERROR_KEYS = ['status', 'developerMessage', 'userMessage', 'errorCode', 'moreInfo'];

    /**
     * Create message For send error
     *
     * @param string $developerMessage Message for developers to use for debugging.
     * @param string $userMessage message for presentation layer.
     * @param integer $status request status
     * @param integer $erroCode contract code between front and backend to write error document.
     *
     * @return array
     */
    private function createErrorMessage(
        $developerMessage,
        $userMessage,
        $status = Response::HTTP_BAD_REQUEST,
        $erroCode = Response::HTTP_BAD_REQUEST
    ): array {

        return array_combine(
            Self::ERROR_KEYS,
            [$status, $developerMessage, $userMessage, $erroCode, null]
        );
    }

    /**
     * Send user registerd information
     *
     * @param object $data user mobile number.
     *
     * @return JsonResponse
     */
    public function userRegistered($data): JsonResponse
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'body' => $data
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    /**
     * Send user information
     *
     * @param array|object $data user mobile number.
     *
     * @return JsonResponse
     */
    public function user($data)
    {
        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'body' => $data
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    public function inputsIsInvalid()
    {
        $message = $this->createErrorMessage(
            __('authService::server-error.inputs-is-invalid'),
            __('authService::client-error.inputs-is-invalid'),
            Response::HTTP_UNAUTHORIZED,
            Response::HTTP_BAD_REQUEST
        );
        return response()->json($message);
    }

    /**
     * User logged in response
     *
     *
     * @param string $token
     * 
     * @return JsonResponse
     */
    public function loggedIn(string $token)
    {

        return response()->json(
            [
                'status' => self::HTTP_SUCCESS_CODE,
                'api_token' => $token,
                'message' => __('authService::message.user-logged-in')
            ],
            self::HTTP_SUCCESS_CODE
        );
    }

    /**
     * Send an error when a server error  occurs
     *
     * @param string $errorMessage the error message that sends to the developer
     *
     * @return JsonResponse
     */
    public function sendServerError($errorMessage)
    {
        $message = $this->createErrorMessage(
            $errorMessage,
            __('authService::client-error.error-occurred'),
            self::HTTP_SERVER_ERROR_CODE,
            self::HTTP_SERVER_ERROR_CODE
        );
        return response()->json($message);
    }
}
