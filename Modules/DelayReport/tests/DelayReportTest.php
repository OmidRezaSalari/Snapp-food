<?php

namespace DelayReportTest;

use DelayReport\Facades\Response\ResponderFacade;
use DelayReport\Facades\Trip\TripProviderFacade;
use DelayReport\Facades\TripHandler\DeliverdTripHandler;
use DelayReport\Facades\TripHandler\InProcessTripHandler;
use DelayReport\Facades\TripHandler\TripHandlerFacade;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    /** @test */
    public function user_can_report_order_delay_when_order_has_not_trip()
    {

        TripProviderFacade::shouldReceive("isValidTrip")
            ->with(1)->once()->andReturnNull();

        $message = __("DelayReportService::message.send-to-delay-queue");
        TripHandlerFacade::shouldProxyTo(DeliverdTripHandler::class);
        TripHandlerFacade::shouldReceive("handle")->with(1)->once()
            ->andReturn($message);


        ResponderFacade::shouldReceive("addReportSuccessfully")
            ->with($message)->once()
            ->andReturn(response()->json(["message" => $message]));

        $res = $this->postJson(route('v1.orders.delays.add-new-report'), ['orderId' => 1]);

        $res->assertSuccessful()->assertJsonFragment(["message" => $message]);
    }

    /** @test */
    public function user_can_report_order_delay_when_order_has_a_trip()
    {

        TripProviderFacade::shouldReceive("isValidTrip")
            ->with(1)->once()->andReturnNull();

        $message = __(
            "DelayReportService::message.predict-time-to-delivery",
            ['time' => 14]
        );

        TripHandlerFacade::shouldProxyTo(InProcessTripHandler::class);
        TripHandlerFacade::shouldReceive("handle")->with(1)->once()
            ->andReturn($message);


        ResponderFacade::shouldReceive("addReportSuccessfully")
            ->with($message)->once()
            ->andReturn(response()->json(["message" => $message]));

        $res = $this->postJson(route('v1.orders.delays.add-new-report'), ['orderId' => 1]);

        $res->assertSuccessful()->assertJsonFragment(["message" => $message]);
    }
}
