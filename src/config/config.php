<?php

return [
    'host' => env('WEBSOCKET_HOST', '0.0.0.0'),
    'port' => env('WEBSOCKET_PORT', 9501),
    'ssl' => env('WEBSOCKET_SSL', false),
    'task_worker_num' => env('WEBSOCKET_TASK_WORKER_NUM', 8),
];
