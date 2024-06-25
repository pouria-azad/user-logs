<?php

namespace Binafy\LaravelUserMonitoring\Traits;

use Binafy\LaravelUserMonitoring\Utills\ActionType;
use Binafy\LaravelUserMonitoring\Utills\Detector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


trait Actionable
{
    /**
     * The "boot" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        if (config('user-monitoring.action_monitoring.on_store', false)) {
            static::created(function (mixed $model) {
                static::insertActionMonitoring($model, ActionType::ACTION_STORE);
            });
        }

        if (config('user-monitoring.action_monitoring.on_update', false)) {
            static::updated(function (mixed $model) {
                if (Auth::id()) {
                    static::insertActionMonitoring($model, ActionType::ACTION_UPDATE);
                }});
        }

        if (config('user-monitoring.action_monitoring.on_destroy', false)) {
            static::deleted(function (mixed $model) {
                static::insertActionMonitoring($model, ActionType::ACTION_DELETE);
            });
        }

        if (config('user-monitoring.action_monitoring.on_read', false)) {
            static::retrieved(function (mixed $model) {
                static::insertActionMonitoring($model, ActionType::ACTION_READ);
            });
        }

        if (config('user-monitoring.action_monitoring.on_replicate', false)) {
            static::replicating(function (mixed $model) {
                static::insertActionMonitoring($model, ActionType::ACTION_REPLICATE);
            });
        }

//        if (config('user-monitoring.action_monitoring.on_replicate', false)) {
//            static::restored(function (mixed $model) {
//                static::insertActionMonitoring($model, ActionType::ACTION_REPLICATE);
//            });
//        }TODO: Release next version
        /*
         * Events:
         * trashed
         * replicating
         * restored
         */
    }

    /**
     * Insert action monitoring into DB.
     */
    private static function insertActionMonitoring(mixed $model, string $actionType): void
    {
        $detector = new Detector();
        $guard = config('user-monitoring.user.guard');

        DB::table(config('user-monitoring.action_monitoring.table'))->insert([
            'action_type' => $actionType,
            'table_name' => $model->getTable(),
            'browser_name' => $detector->getBrowser(),
            'platform' => $detector->getDevice(),
            'device' => $detector->getDevice(),
            'ip' => request()->ip(),
            'page' => request()->url(),
            'created_at' => now(),
            'updated_at' => now(),
            'new_column_id'=>$model->getKey(),
            'consumer_id' => Auth::id(),
            'consumer_type'=> $detector->get_guard()
        ]);
    }
}
