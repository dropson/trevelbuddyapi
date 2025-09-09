<?php

declare(strict_types=1);

use App\Enums\TripStatusEnum;
use App\Enums\UserGenderEnum;
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
        Schema::create('trips', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('image_path')->nullable();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default(TripStatusEnum::DRAFT->value)
                ->checkIn(TripStatusEnum::cases());
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->unsignedInteger('max_mates')->default(1);
            $table->enum('gender_preference', UserGenderEnum::cases())->nullable();
            $table->string('accommodation')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
