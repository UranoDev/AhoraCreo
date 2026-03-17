<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('pdf_sent')->default(false);
            $table->timestamp('pdf_sent_at')->nullable();
            $table->boolean('pdf_downloaded')->default(false);
            $table->timestamp('pdf_downloaded_at')->nullable();
            $table->timestamps();

            $table->index(['email_verified_at', 'pdf_sent', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
