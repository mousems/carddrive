<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Google application name
    |----------------------------------------------------------------------------
    */
    'application_name' => 'Card Drive',

    /*
    |----------------------------------------------------------------------------
    | Google OAuth 2.0 access
    |----------------------------------------------------------------------------
    |
    | Keys for OAuth 2.0 access, see the API console at
    | https://developers.google.com/console
    |
    */
    'client_id'       => '1067770203431-q9gqgijmr7kmtit8gugbjaivbdcr1a5q.apps.googleusercontent.com',
    'client_secret'   => 'rfE3U0JJiVEv5f5KMKr1rand',
    'redirect_uri'    => 'http://localhost:8000/auth_callback',
    // 'redirect_uri'    => 'http://carddrive.mousems.me/auth_callback'
    // 'scopes'          => ['https://www.googleapis.com/auth/drive.appfolder'],
    'scopes'          => ['https://www.googleapis.com/auth/drive'],
    'access_type'     => 'online',
    'approval_prompt' => 'force',

    /*
    |----------------------------------------------------------------------------
    | Google developer key
    |----------------------------------------------------------------------------
    |
    | Simple API access key, also from the API console. Ensure you get
    | a Server key, and not a Browser key.
    |
    */
    'developer_key' => '',

    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Enable and set the information below to use assert credentials
    | Enable and leave blank to use app engine or compute engine.
    |
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => false,

        /*
        | Example xxx@developer.gserviceaccount.com
        */
        'account' => '',

        /*
        | Example ['https://www.googleapis.com/auth/cloud-platform']
        */
        'scopes' => [],

        /*
        | Path to key file
        | Example storage_path().'/key/google.p12'
        */
        'key' => '',
    ],
];
