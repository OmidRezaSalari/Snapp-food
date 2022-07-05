<?php

namespace DelayReport\Facades\Response;

use DelayReport\Facades\BaseFacade;
use Illuminate\Http\JsonResponse;

/**
 * @method static JsonResponse sendServerError(string $errorCode)
 * @method static JsonResponse tripNotExist()
 * @method static JsonResponse queueIsEmpty()
 * @method static JsonResponse tripNotExist()
 * @method static JsonResponse addReportSuccessfully(string $message)
 */

class ResponderFacade extends BaseFacade
{
}
