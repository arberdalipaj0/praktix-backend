<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->string('duration')->comment('e.g. 3 months, 12 weeks');
            $table->decimal('price', 10, 2);
            $table->string('image_url')->nullable();
            $table->foreignId('expert_id')->constrained('experts')->onDelete('cascade');
            $table->boolean('certificate_included')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
