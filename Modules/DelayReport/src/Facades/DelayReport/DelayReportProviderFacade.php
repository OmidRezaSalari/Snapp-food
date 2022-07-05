<?php

namespace DelayReport\Facades\DelayReport;

use DelayReport\Facades\BaseFacade;
use DelayReport\Models\Agent;

/**
 * @method static void create(array $data)
 * @method static Agent|null AgentIsBusy(int $agentID)
 * @method static void accessToAgent(int $orderID)
 */
class DelayReportProviderFacade extends BaseFacade
{
}
