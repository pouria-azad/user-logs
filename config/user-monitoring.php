<?php

return [
    /*
     * Configurations.
     */
    'config' => [
        'routes' => [
            'file_path' => 'routes/user-monitoring.php',
        ],
    ],

        'guards'=>[
            'web'=> 'App\Models\User',
            'brokers'=> 'App\Models\Broker',
            'managers'=> 'App\Models\Manager',
        ],

    /*
     * User properties.
     *
     * You can customize the user guard, table, foreign key, and ... .
     */
    'user' => [
        /*
         * User model.
         */
        'model' => 'App\Models\User',

        /*
         * Foreign Key column name.
         */
        'foreign_key' => 'user_id',

        /*
         * Users table name.
         */
        'table' => 'users',

        /*
         * The correct guard.
         */
        'guard' => 'web',

    ],

    /*
     * Visit monitoring configurations.
     */
    'visit_monitoring' => [
        'table' => 'visits_monitoring',

        /*
         * If you want to disable visit monitoring, set it to false.
         */
        'turn_on' => true,

        /*
         * If you want to disable visit monitoring in Ajax mode, set it to false.
         */
        'ajax_requests' => true,

        /*
         * You can specify pages not to be monitored.
         */
        'except_pages' => [
            // 'home',
        ],

        /*
         * If you want to delete visit rows after some days, you can change this to 360 for example,
         * but you don't like to delete rows you can change it to 0.
         *
         * For this feature you need Task-Scheduling => https://laravel.com/docs/10.x/scheduling
         */
        'delete_days' => 0,
    ],

    /*
     * Action monitoring configurations.
     */
    'action_monitoring' => [
        'table' => 'actions_monitoring',

        /*
         * Monitor actions.
         *
         * You can set true/false for monitor actions like (store, update, and ...).
         */
        'on_store'      => true,
        'on_update'     => true,
        'on_destroy'    => true,
        'on_read'       => true,
        'on_restore'    => false, // Release for next version :)
        'on_replicate'  => false,
    ],

    /*
     * Authentication monitoring configurations.
     */
    'authentication_monitoring' => [
        'table' => 'authentications_monitoring',

        /*
         * If you want to delete authentications-monitoring rows when the user is deleted from the users table you can set true or false.
         */
        'delete_user_record_when_user_delete' => true,

        /*
         * You can set true/false for monitor login or logout.
         */
        'on_login' => true,
        'on_logout' => true,
    ],
];
