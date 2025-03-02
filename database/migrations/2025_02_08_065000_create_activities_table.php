<?php

use App\Enums\StudentStatus;
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->text('description');
            $table->string('type');
            $table->string('slug')->unique();
            $table->string('document')->nullable();
            $table->string('status')->default(StudentStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
