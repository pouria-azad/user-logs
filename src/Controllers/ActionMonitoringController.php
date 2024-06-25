<?php

namespace Binafy\LaravelUserMonitoring\Controllers;

use Binafy\LaravelUserMonitoring\Models\ActionMonitoring;
use Illuminate\Support\Facades\DB;

class ActionMonitoringController extends BaseController
{
    public function index()
    {
        $actions = ActionMonitoring::query()->latest()->paginate();

        if (view()->exists('vendor.laravel-user-monitoring.actions-monitoring.index')) {
            return view('vendor.laravel-user-monitoring.actions-monitoring.index', compact('actions'));
        }
        return view('LaravelUserMonitoring::actions-monitoring.index', compact('actions'));
    }

    public function destroy(int $id)
    {
        DB::table(config('user-monitoring.action_monitoring.table'))
            ->where('id', $id)
            ->delete();

        return to_route('user-monitoring.actions-monitoring');
    }
}
