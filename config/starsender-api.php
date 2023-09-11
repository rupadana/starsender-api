<?php

// config for Rupadana/StarsenderApi
return [
    'is_production' => (bool) env('STARSENDER_IS_PRODUCTION', false),

    'api_key' => env('STARSENDER_API_KEY', null),
    
    'force_message_to' => env('STARSENDER_FORCE_MESSAGE_TO', null)
];
