<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Platform Bank Details
    |--------------------------------------------------------------------------
    |
    | These are the bank account details shown to schools on the billing
    | page so they can make bank transfer payments for their subscription.
    |
    */

    'bank' => [
        'name' => env('PLATFORM_BANK_NAME', 'Guaranty Trust Bank (GTBank)'),
        'account_name' => env('PLATFORM_BANK_ACCOUNT_NAME', 'EASYSOLVE Technologies'),
        'account_number' => env('PLATFORM_BANK_ACCOUNT_NUMBER', '0123456789'),
        'sort_code' => env('PLATFORM_BANK_SORT_CODE', ''),
        'transfer_note' => env('PLATFORM_BANK_TRANSFER_NOTE', 'Use your school name as the transfer reference.'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '₦'),

];
