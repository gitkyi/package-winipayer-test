<?php

// config for Winipayer/Winipayer
return [

    'env' => env('WINIPAYER_ENV', 'test'),

    'apply_key' => env('WINIPAYER_APPLY_KEY', ''),

    'token_key' => env('WINIPAYER_TOKEN_KEY', ''),

    'private_key' => env('WINIPAYER_PRIVATE_KEY', ''),

    'wpsecure' => env('WINIPAYER_WPSECURE', ''),

    'cancel_url' => env('WINIPAYER_CANCEL_URL', ''),

    'return_url' => env('WINIPAYER_RETURN_URL', ''),

    'callback_url' => env('WINIPAYER_CALLBACK_URL', ''),

];
