<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->security();

arch('modular laravel', function (): void {
    expect('App\Http\Controllers')->toHaveSuffix('Controller')
        ->and('App\*\Http\Controllers')->toHaveSuffix('Controller');
});
