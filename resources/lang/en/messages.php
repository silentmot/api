<?php

return [
    'exception'         => [
        '404' => [
            'model' => 'Document or file requested by the client was not found.',
            'http'  => 'Page not found!'
        ],
        '403' => 'Access is denied.',
        '413' => 'Payload is too large.',
        '500' => 'Internal Server Error.',
    ],
];
