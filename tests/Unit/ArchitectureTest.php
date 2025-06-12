<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->security();

arch('modular laravel', function (): void {
    expect('App\Http\Controllers')
        ->not->toBeClasses()
        ->and('App\*\Http\Controllers')
        ->toHaveSuffix('Controller')
        ->toExtendNothing()
        ->not->toHavePublicMethodsBesides([
            '__invoke',
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
});
