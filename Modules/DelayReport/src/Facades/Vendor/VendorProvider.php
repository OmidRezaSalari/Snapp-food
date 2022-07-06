<?php

namespace DelayReport\Facades\Vendor;

use DelayReport\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;

class VendorProvider
{

    /** @var Vendor */
    private $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get vendors with their delay reports count
     * 
     * @return array
     */
    public function getWithDelayReportCount()
    {
        return $this->vendor->withCount(['delayReports' => function (Builder $query) {
            $query->where('delay_reports.created_at', '>=', now()->subWeek());
        }])->oldest()->paginate(10);
    }
}
