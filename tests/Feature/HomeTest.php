<?php

declare(strict_types=1);

test('home is rendered successfully', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
