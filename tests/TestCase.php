<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->shuffleAutoIncrementIds();
    }

    final public function asGuest(?string $guard = null): self
    {
        $this->app['auth']->guard($guard)->forgetUser();

        return $this;
    }

    /**
     * Randomizes the starting id of each model.
     */
    private function shuffleAutoIncrementIds(): void
    {
        DB::table('sqlite_sequence')
            ->update([
                'seq' => DB::raw('ABS(RANDOM() % 999999) + 1'),
            ]);
    }
}
