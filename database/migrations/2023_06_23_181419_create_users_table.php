<?php

use BandManager\App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('display_name');

            $table->string('email', 255)
                ->unique()
                ->nullable()
                ->default(null);

            $table->string('password', 255)
                ->nullable()
                ->default(null);

            $table->string('fb_id', 255)
                ->unique()
                ->nullable()
                ->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
