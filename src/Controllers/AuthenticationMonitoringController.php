<?php

namespace Binafy\LaravelUserMonitoring\Controllers;

use Binafy\LaravelUserMonitoring\Models\AuthenticationMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthenticationMonitoringController extends BaseController
{
    public function index(Request $request)
    {
        $index = -1;
        $url = $request->url();
        $type = '';
        $segments = explode('/', $url);
        foreach (array_keys(config('user-monitoring.guards'))as $value) {
            if (($value === $segments[count($segments)-2])) {
                $type = $value;
                break;
            }
        }

        $authentications = AuthenticationMonitoring::query()->latest()->paginate();
        if (view()->exists('vendor.laravel-user-monitoring.authentications-monitoring' . '.' . $type . '.' . 'index')) {
            return view('vendor.laravel-user-monitoring.authentications-monitoring' . '.' . $type . '.' . 'index', compact('authentications'));
        }
        return view('LaravelUserMonitoring::authentications-monitoring.index', compact('authentications'));
    }

    public function destroy(Request $request, int $id)
    {
        DB::table(config('user-monitoring.authentication_monitoring.table'))
            ->where('id', $id)
            ->delete();

        return to_route('user-monitoring' . '.' . $request->type . '.' . 'authentications-monitoring');
    }
}
