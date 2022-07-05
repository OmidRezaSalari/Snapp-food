<?php

namespace DelayReport\Controllers\V1;

use App\Http\Controllers\Controller;
use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\Message\MessageSenderFacade;
use DelayReport\Facades\Response\ResponderFacade;
use DelayReport\Facades\TripHandler\TripHandlerFacade;
use DelayReport\Facades\Trip\TripProviderFacade;
use DelayReport\Requests\V1\AddDelayReportRequest;
use Exception;

class DelayReportController extends Controller
{

    public function addReport(AddDelayReportRequest $request)
    {
        try {
            $validData = $request->validated();
            TripProviderFacade::isValidTrip($validData["orderId"]);
            $message = TripHandlerFacade::handle($validData["orderId"]);

            return ResponderFacade::addReportSuccessfully($message);
        } catch (Exception $exception) {
            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }
    }

    public function sendForReview()
    {
        try {

            if ($orderId = MessageSenderFacade::received()) {

                DelayReportProviderFacade::accessToAgent($orderId);

                return ResponderFacade::accessToAgentSuccessfully();
            }

            return ResponderFacade::queueIsEmpty();
        } catch (Exception $exception) {
            ResponderFacade::sendServerError($exception->getMessage())->throwResponse();
        }
    }
}
