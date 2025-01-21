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
        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('profile_status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });

        // User Profiles Table
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->enum('role', ['freelancer', 'client', 'admin']);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->json('skills')->nullable();
            $table->string('location')->nullable();
            $table->string('company_name')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });

        // Roles Table
        // Schema::create('roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->uuid('uuid')->unique(); // External reference
        //     $table->string('name')->unique();
        //     $table->timestamps();
        // });

        // User Roles Table
        // Schema::create('user_roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->uuid('uuid')->unique(); // External reference
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
        //     $table->timestamps();
        // });

        // Work Table
        Schema::create('work', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('client_id')->constrained('user_profiles')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 15, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->enum('work_type', ['fixed', 'hourly']);
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->json('skills_required')->nullable();
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->timestamps();
        });

        // Proposals Table
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('work_id')->constrained('work')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('user_profiles')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->decimal('bid_amount', 15, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Contracts Table
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('work_id')->constrained('work')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('user_profiles')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('payment_type', ['fixed', 'hourly']);
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
        });

        // Payments Table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->timestamp('payment_date')->useCurrent();
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer'])->nullable();
            $table->timestamps();
        });

        // Messages Table
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('sender_id')->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('user_profiles')->onDelete('cascade');
            $table->text('content');
            $table->boolean('read_status')->default(false);
            $table->timestamps();
        });

        // Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });

        // Reviews Table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('user_profiles')->onDelete('cascade');
            $table->foreignId('reviewee_id')->constrained('user_profiles')->onDelete('cascade');
            $table->integer('rating')->check('rating >= 1 AND rating <= 5');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // External reference
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['proposal', 'payment', 'work', 'message', 'review']);
            $table->text('content')->nullable();
            $table->boolean('read_status')->default(false);
            $table->timestamps();
        });

        // Password Reset Tokens Table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions Table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_profiles');
       // Schema::dropIfExists('roles');
       // Schema::dropIfExists('user_roles');
        Schema::dropIfExists('work');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
