<?php

namespace DelayReport\Facades\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VueResponder
{
    public const HTTP_SUCCESS_CODE = 200;
    public const HTTP_CLIENT_ERROR_CODE = 400;
    public const HTTP_SERVER_ERROR_CODE = 500;

    public const ERROR_KEYS = ['status', 'developerMessage', 'userMessage', 'errorCode', 'moreInfo'];

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
     * When trip not exist
     *
     *
     * @return JsonResponse
     */

    public function tripNotExist()
    {
        $message = $this->createErrorMessage(
            __('DelayReportService::server-error.trip-not-exist'),
            __('DelayReportService::client-error.tip-not-exist'),
            Response::HTTP_NOT_FOUND,
            Response::HTTP_BAD_REQUEST
        );
        return response()->json($message);
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
            __('DelayReportService::client-error.error-occurred'),
            self::HTTP_SERVER_ERROR_CODE,
            self::HTTP_SERVER_ERROR_CODE
        );
        return response()->json($message);
    }
}
