<?php

return [
    'meta' => [
        'type' => 'chat_message',
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
        'text' => 'foo',
        'room' => [
            'id' => 'myRoomId',
        ],
        'id' => 'fakeMessageId',
        'ts' => 1517562468092,
    ],
];
