<?php

namespace Binafy\LaravelUserMonitoring\Providers;

use Binafy\LaravelUserMonitoring\Utills\Detector;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class LaravelUserMonitoringEventServiceProvider extends EventServiceProvider
{
    public function boot(): void
    {
        $detector = new Detector();
        $table = config('user-monitoring.authentication_monitoring.table');

        // Login Event
        if (config('user-monitoring.authentication_monitoring.on_login', false)) {
            Event::listen(function (Login $event) use ($detector, $table) {
                DB::table($table)
                    ->insert(
                        $this->insertData($event->guard, $detector, $event->user->getAuthIdentifier(), 'Login'),
                    );
            });
        }

        // Logout Event
        if (config('user-monitoring.authentication_monitoring.on_logout', false)) {
            Event::listen(function (Logout $event) use ($detector, $table) {
                DB::table($table)
                    ->insert(
                        $this->insertData($event->guard, $detector, $event->user->getAuthIdentifier(), 'Logout'),
                    );
            });
        }
    }

    /**
     * Get insert data.
     */
    private function insertData(string $guard, Detector $detector, int|null $id, string $actionType): array
    {
        foreach (array_keys(config('user-monitoring.guards')) as $mo) {
            if ($guard === $mo) {
                $guard = config('user-monitoring.guards')[$mo];
            }
        }
        return [
            'action_type' => $actionType,
            'browser_name' => $detector->getBrowser(),
            'platform' => $detector->getDevice(),
            'device' => $detector->getDevice(),
            'ip' => request()->ip(),
            'page' => request()->url(),
            'created_at' => now(),
            'updated_at' => now(),
            'consumer_id'=>$id,
            'consumer_type' =>$guard,
        ];
    }
}
