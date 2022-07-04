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

    public function create(array $data)
    {
        $this->delayReport->create([
            "order_id" => $data["order-id"],
            "status" => $data["status"],
        ]);
    }
}
