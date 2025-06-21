<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    final public function asGuest(?string $guard = null): self
    {
        $this->app['auth']->guard($guard)->forgetUser();

        return $this;
    }
}
