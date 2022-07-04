<?php

namespace DelayReport\Controllers\V1;

use App\Http\Controllers\Controller;
use DelayReport\Facades\Response\ResponderFacade;
use DelayReport\Facades\TripHandler\TripHandlerFacade;
use DelayReport\Facades\Trip\TripProviderFacade;
use DelayReport\Requests\V1\AddDelayReportRequest;

class DelayReportController extends Controller
{

    public function addReports(AddDelayReportRequest $request)
    {
        $validData = $request->validated();

        $trip = TripProviderFacade::isValidTrip($validData["orderId"]);

        $message = TripHandlerFacade::handle($trip->order_id);
        
        ResponderFacade::addReportSuccessfully($message);
        //check trip  if exist and check status
    }
}
