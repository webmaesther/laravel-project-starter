<?php

declare(strict_types=1);

use SoloTerm\Solo\Commands\Command;
use SoloTerm\Solo\Hotkeys;
use SoloTerm\Solo\Themes;

// Solo may not (should not!) exist in prod, so we have to
// check here first to see if it's installed.
if (! class_exists(SoloTerm\Solo\Manager::class)) {
    return [
        //
    ];
}

return [
    /*
    |--------------------------------------------------------------------------
    | Themes
    |--------------------------------------------------------------------------
    */
    'theme' => env('SOLO_THEME', 'dark'),

    'themes' => [
        'light' => Themes\LightTheme::class,
        'dark' => Themes\DarkTheme::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Keybindings
    |--------------------------------------------------------------------------
    */
    'keybinding' => env('SOLO_KEYBINDING', 'default'),

    'keybindings' => [
        'default' => Hotkeys\DefaultHotkeys::class,
        'vim' => Hotkeys\VimHotkeys::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    */
    'commands' => [
        // Environment...
        'HTTP' => Command::from('php artisan octane:start --watch'),
        'SSR' => Command::from('php artisan inertia:start-ssr'),
        'Tinker' => Command::from('php artisan tinker')->interactive(),
        'Sail' => Command::from('vendor/bin/sail up')->interactive(),
        'Pail' => Command::from('php artisan pail -vv'),
        'Dumps' => Command::from('php artisan solo:dumps'),
        'Horizon' => Command::from('php artisan horizon'),
        'Reverb' => Command::from('php artisan reverb:start --debug'),
        'Tasks' => Command::from('php artisan schedule:work'),

        // Tests...
        'Pest' => Command::from('vendor/bin/pest --watch=app,src,routes,tests')->lazy(),
        'Vitest' => Command::from('npm run test')->lazy(),

        // Validators
        'Types' => Command::from('npm run type:check')->lazy(),
        'Dusk' => Command::from('php artisan dusk')->lazy(),
        'Peck' => Command::from('vendor/bin/peck')->lazy(),

        // Helpers...
        'Rector' => Command::from('vendor/bin/rector')->lazy(),
        'Pint' => Command::from('vendor/bin/pint')->lazy(),
        'Eslint' => Command::from('npm run lint')->lazy(),
        'Prettier' => Command::from('npm run format')->lazy(),

        // Frontend
        'Dev' => Command::from('npm run dev')->lazy(),
        'Build' => Command::from('npm run build:ssr')->lazy(),
    ],

    /**
     * By default, we prefer to use GNU Screen as an intermediary between Solo
     * and the underlying process. This helps us with many issues, including
     * PTY and some ANSI rendering things. Not all environments have Screen,
     * so you can turn it off for a slightly degraded experience.
     */
    'use_screen' => (bool) env('SOLO_USE_SCREEN', true),

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */

    /*
     * If you run the solo:dumps command, Solo will start a server to receive
     * the dumps. This is the address. You probably don't need to change
     * this unless the default is already taken for some reason.
     */
    'dump_server_host' => env('SOLO_DUMP_SERVER_HOST', 'tcp://127.0.0.1:9984'),
];
