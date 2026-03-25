<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment Simulation Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, payments will be simulated without connecting to real
    | payment gateways. Perfect for testing and development.
    |
    */

    'simulation_mode' => env('PAYMENT_SIMULATION', true),

    /*
    |--------------------------------------------------------------------------
    | Simulation Settings
    |--------------------------------------------------------------------------
    |
    | Configure simulation behavior: success rate (percentage) and delay
    | (seconds) to simulate real payment processing time.
    |
    */

    'simulation_success_rate' => env('PAYMENT_SUCCESS_RATE', 90),
    'simulation_delay' => env('PAYMENT_DELAY', 2),

    /*
    |--------------------------------------------------------------------------
    | Token Packages
    |--------------------------------------------------------------------------
    |
    | Available token packages for purchase with their prices in USD.
    |
    */

    'token_packages' => [
        100 => 9.99,
        500 => 49.99,
        1000 => 89.99,
        5000 => 399.99,
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Value (USD)
    |--------------------------------------------------------------------------
    |
    | The estimated USD value per token, used for financial reporting.
    |
    */

    'token_value' => env('TOKEN_VALUE_USD', 0.10),

    /*
    |--------------------------------------------------------------------------
    | Supported Payment Methods
    |--------------------------------------------------------------------------
    |
    | Payment methods available in the platform.
    |
    */

    'supported_methods' => ['card', 'paypal', 'skrill'],

    /*
    |--------------------------------------------------------------------------
    | Test Cards (Simulation Mode)
    |--------------------------------------------------------------------------
    |
    | Test card numbers for simulation mode:
    | - 4242 4242 4242 4242: Success
    | - 4000 0000 0000 0002: Declined
    | - 4000 0000 0000 9995: Insufficient funds
    |
    */

    'test_cards' => [
        'success' => '4242424242424242',
        'declined' => '4000000000000002',
        'insufficient_funds' => '4000000000009995',
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Default currency for all transactions.
    |
    */

    'currency' => env('PAYMENT_CURRENCY', 'USD'),

];
