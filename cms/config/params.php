<?php

return [
    'adminEmail' => 'admin@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'token_secret_string'=> 'some_random_string',
    'rateLimiter' => [
    	'limit' => 100,
    	'period' => 600,
    	'separate' => false,
    ],
];