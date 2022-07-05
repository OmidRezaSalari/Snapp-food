<?php

namespace DelayReport\Middleware;

use Closure;
use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\Response\ResponderFacade;

class BusyAgent
{
    public function handle($request, Closure $next)
    {
        $onlineAgent = auth()->user()->id;

        if (DelayReportProviderFacade::AgentIsBusy($onlineAgent)) {

            return ResponderFacade::agentIsBusy($onlineAgent);
        }

        return $next($request);
    }
}
