<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('cv_url')->nullable()->comment('URL or file path to CV');
            $table->enum('status', ['new', 'under_review', 'accepted', 'rejected'])->default('new');
            $table->text('notes')->nullable()->comment('Admin notes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
