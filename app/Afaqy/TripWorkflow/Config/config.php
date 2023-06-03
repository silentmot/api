<?php

return [
    'plc'                 => [
        'url'           => env('PLC_URL', 'http://ws.jeddah.gov.sa/ARInterfaceWSProd/Mrdm.asmx?WSDL'),
        'function_name' => env('PLC_FUNCTION_NAME', 'AddNewMardm'),
        'guid'          => env('PLC_GUID', '9EC16D0B-6E9A-05BB-E053-1D64A8C0E7EF'),
    ],
    'avl'                 => [
        'vision' => env('AVL_VISION_URL', 'http://jeddahwcts.com:5555/TrackingAPI/api/Compactor/History'),
    ],
    'cap'                 => [
        'url'           => env('CAP_URL', 'https://madinati.sa/WasteAPI/api/Transactions/AddTransaction'),
        'authorization' => env('CAP_AUTHORIZATION', 'dc58e676-949a-46ce-9d20-04350177fc79'),
    ],
    'masader'           => [
        'login_url'         => env('MASADER_LOGIN_URL', 'https://clnapi.jeddah.gov.sa/api/Account/Authentication/Login'),
        'log_url'           => env('MASADER_LOG_URL', 'https://clnapi.jeddah.gov.sa/api/MurdamManagment/Murdam/AddMurdam'),
        'username'          => env('MASADER_USERNAME', 'mardam@jeddah.gov.sa'),
        'password'          => env('MASADER_PASSWORD', '123456'),
    ],
    'message'             => [
        'goToFirstScale',
        'goToSecondScale',
        'goToThirdScale',
        'carIsNotRegisterGoToSecurityOffice',
        'welcome',
    ],
    'trivial_time_amount' => env('TRIVIAL_TIME_AMOUNT', 1),
];
