<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies\Models;

use Illuminate\Database\Eloquent\Model;
use Tests\Feature\Playwright\Dummies\SubscriptionFactory;

final class Subscription extends Model
{
    public static function factory(): SubscriptionFactory
    {
        return new SubscriptionFactory();
    }
}
