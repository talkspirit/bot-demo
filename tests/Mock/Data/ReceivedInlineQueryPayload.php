<?php

return [
    'meta' => [
        'type' => 'inline_query',
        'host' => 'myHost',
        'id' => 'fakeId',
        'token' => 'myToken',
        'app_name' => 'appName',
    ],
    'data' => [
        'from' => [
            'id' => 'userSlug',
            'displayname' => 'displayName',
            'type' => 'user',
        ],
        'text' => '',
        'room' => [
            'id' => 'myRoomId',
        ],
        'id' => 'fakeMessageId',
        'ts' => 1517562468092,
        'command' => 'myCommand',
    ],
];
