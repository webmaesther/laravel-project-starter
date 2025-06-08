<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies;

use Illuminate\Database\Eloquent\Model;

final class Subscription extends Model
{
    public static function factory(): SubscriptionFactory
    {
        return new SubscriptionFactory();
    }
}
