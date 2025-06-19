<?php

declare(strict_types=1);

use App\Enums\SocialiteDriver;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('identities', function (Blueprint $table): void {
            $table->id();
            $table->enum('driver', array_column(SocialiteDriver::cases(), 'value'));
            $table->string('external_id');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federated_accounts');
    }
};
