<?php

namespace DelayReport\Facades\DelayReport;

use DelayReport\Models\DelayReport;

class DelayReportProvider
{
    /** @var DelayReport */

    private $delayReport;

    public function __construct(DelayReport $delayReport)
    {
        $this->delayReport = $delayReport;
    }

    /**
     * create new delay report
     * 
     * @param array $data
     * 
     * @return void
     */

    public function create(array $data)
    {
        $this->delayReport->create([
            "order_id" => $data["order-id"],
            "status" => $data["status"],
        ]);
    }

    /**
     * check agent is busy in delay reports
     * 
     * @param int $agentID
     * 
     * @return DelayReport|null
     */

    public function AgentIsBusy(int $agentID)
    {
        return $this->delayReport->where('agent_id', $agentID)->delay()->first();
    }

    /**
     * access order delay reports to aget
     * 
     * @param int $orderID
     * 
     * @return void
     */

    public function accessToAgent(int $orderID)
    {
        $this->delayReport->where('order_id', $orderID)->delay()
            ->update(['agent_id' => auth()->user()->id, "status" => "PICKED"]);
    }
}
