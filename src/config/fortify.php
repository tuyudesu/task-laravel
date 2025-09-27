<?php

use Laravel\Fortify\Features;

return [

    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',

    // FortifyがBladeを使う（/login, /register を自前ビューで出す）
    'views' => true,

    'home' => '/admin',

    'middleware' => ['web'],

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication(),
    ],
];
