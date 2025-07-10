<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('student_id_number')->unique();
            $table->string('firstname')->nullable();
            $table->string('surname')->nullable();
            $table->string('father_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('passport_pnfl')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('group_name')->nullable();
            $table->string('education_form')->nullable();
            $table->string('education_type')->nullable();
            $table->string('avg_gpa')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('country')->nullable();
            $table->string('livel')->nullable();
            $table->string('type')->default('student'); // 'student', 'teacher', 'admin'
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('login')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
