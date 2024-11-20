<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'allowed_host' => getenv('DOMAIN') ?: 'http://localhost',
    'jwt' => [
        'key' => getenv('API_JWT_SECRET_KEY') ?: '07h@m6U$V*G^eq345@u2OaN4rLxTE24uM!Y!0$y9@2%vq2LONQ',
    ],
];
