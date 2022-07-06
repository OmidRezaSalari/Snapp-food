<?php

namespace DelayReportTest;

use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\Message\MessageSenderFacade;
use DelayReport\Facades\Response\ResponderFacade;
use DelayReport\Facades\Trip\TripProviderFacade;
use DelayReport\Facades\TripHandler\DeliverdTripHandler;
use DelayReport\Facades\TripHandler\InProcessTripHandler;
use DelayReport\Facades\TripHandler\TripHandlerFacade;
use DelayReport\Models\Order;
use DelayReport\Models\Vendor;
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

        $orderId = Order::factory()
            ->count(1)
            ->for(Vendor::factory())->create()->first()->id;


        TripProviderFacade::shouldReceive("isValidTrip")
            ->with($orderId)->once()->andReturnNull();

        $message = __("DelayReportService::message.send-to-delay-queue");
        TripHandlerFacade::shouldProxyTo(DeliverdTripHandler::class);
        TripHandlerFacade::shouldReceive("handle")->with($orderId)->once()
            ->andReturn($message);


        ResponderFacade::shouldReceive("addReportSuccessfully")
            ->with($message)->once()
            ->andReturn(response()->json(["message" => $message]));

        $res = $this->postJson(route('v1.orders.add-delay-report'), ['orderId' => $orderId]);

        $res->assertSuccessful()->assertJsonFragment(["message" => $message]);
    }

    /** @test */
    public function user_can_report_order_delay_when_order_has_a_trip()
    {

        $orderId = Order::factory()
            ->count(1)
            ->for(Vendor::factory())->create()->first()->id;

        TripProviderFacade::shouldReceive("isValidTrip")
            ->with($orderId)->once()->andReturnNull();

        $message = __(
            "DelayReportService::message.predict-time-to-delivery",
            ['time' => 14]
        );

        TripHandlerFacade::shouldProxyTo(InProcessTripHandler::class);
        TripHandlerFacade::shouldReceive("handle")->with($orderId)->once()
            ->andReturn($message);


        ResponderFacade::shouldReceive("addReportSuccessfully")
            ->with($message)->once()
            ->andReturn(response()->json(["message" => $message]));

        $res = $this->postJson(route('v1.orders.add-delay-report'), ['orderId' => $orderId]);

        $res->assertSuccessful()->assertJsonFragment(["message" => $message]);
    }

    /** @test */
    public function when_assign_delay_report_to_agent_successfully()
    {

        MessageSenderFacade::shouldReceive("received")->withNoArgs()->once()->andReturn(1);

        DelayReportProviderFacade::shouldReceive("accessToAgent")->with(1)->once();

        $message = __("DelayReportService::message.access-to-agent");

        ResponderFacade::shouldReceive("accessToAgentSuccessfully")->withNoArgs()
            ->once()->andReturn(response()->json(['message' => $message]));

        ResponderFacade::shouldReceive("queueIsEmpty")->never();

        $res = $this->postJson(route('v1.orders.forReviews'));
    }

    /** @test */
    public function queue_is_empty_when_assign_delay_report_to_agent()
    {

        MessageSenderFacade::shouldReceive("received")->withNoArgs()->once()->andReturnNull();

        DelayReportProviderFacade::shouldReceive("accessToAgent")->never();

        $message = __("DelayReportService::client-error.delay-queue-is-empty");

        ResponderFacade::shouldReceive("accessToAgentSuccessfully")->never();

        ResponderFacade::shouldReceive("queueIsEmpty")->withNoArgs()
            ->once()->andReturn(response()->json(['message' => $message]));

        $res = $this->postJson(route('v1.orders.forReviews'));
    }
}
