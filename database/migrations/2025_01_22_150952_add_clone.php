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
        

    // User Profiles Table
    Schema::create('user_profiles', function (Blueprint $table) {
        $table->id();
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

     
    // works Table
    Schema::create('works', function (Blueprint $table) {
        $table->id();
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
        $table->foreignId('work_id')->constrained('works')->onDelete('cascade');
        $table->foreignId('freelancer_id')->constrained('user_profiles')->onDelete('cascade');
        $table->text('cover_letter')->nullable();
        $table->decimal('bid_amount', 15, 2)->nullable();
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        $table->timestamps();
    });

    // Contracts Table
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('work_id')->constrained('works')->onDelete('cascade');
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
        $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
        $table->decimal('amount', 15, 2);
        $table->timestamp('payment_date')->useCurrent();
        $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer'])->nullable();
        $table->timestamps();
    });

    // Messages Table
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained('user_profiles')->onDelete('cascade');
        $table->foreignId('receiver_id')->constrained('user_profiles')->onDelete('cascade');
        $table->text('content');
        $table->boolean('read_status')->default(false);
        $table->timestamps();
    });

    // Categories Table
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
        $table->timestamps();
    });

    // Reviews Table
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
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
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->enum('type', ['proposal', 'payment', 'job', 'message', 'review']);
        $table->text('content')->nullable();
        $table->boolean('read_status')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('works');
   
        Schema::dropIfExists('user_profiles');
        
    }
};
