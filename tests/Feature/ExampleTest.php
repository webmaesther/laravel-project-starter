<?php

declare(strict_types=1);

use App\Models\User;

test('the application returns a successful response', function (): void {
    User::factory()->create();

    $response = $this->get('/');

    $response->assertStatus(200);
});
