<?php
return [
    'app_id' => env('WFC_APP_ID', 'wxde95d6f172b45ad6'),
    'secret' => env('WFC_SECRET', 'ff66610af896531e529527deb36a257b'),

    // 缓存前缀（前缀+openid）
    'cache_prefix' => env('WFC_CACHE_PREFIX', 'formid_'),

    // formId的过期时长
    'expire_second' => env('WFC_EXPIRE_SECOND', 7 * 24 * 3600),

    // 缓存驱动
    'cache_driver' => env('WFC_CACHE_DRIVER', 'file'),
];