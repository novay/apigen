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
        Schema::create('wip_datasets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('wip_endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('base_url')->nullable();
            $table->string('base_method')->nullable();
            $table->string('path')->nullable();
            $table->string('method')->nullable();
            $table->string('scope')->nullable();
            $table->bigInteger('dataset_id')->nullable();
            $table->integer('is_official')->default(0);
            $table->integer('is_active')->default(0);
            $table->timestamps();
        });

        Schema::create('wip_settings', function (Blueprint $table) {
            $table->id();
            $table->string('driver')->default('mysql');
            $table->string('host')->nullable();
            $table->integer('port')->nullable();
            $table->string('database')->nullable();
            $table->string('username')->nullable();
            $table->text('password')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('wip_users', function (Blueprint $table) {
            $table->id();
            $table->text('token')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_nama')->nullable();
            $table->bigInteger('opd_id')->nullable();
            $table->string('opd_nama')->nullable();
            $table->timestamps();
        });

        Schema::create('wip_generate', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('module');
            $table->json('columns');
            $table->json('methods');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wip_datasets');
        Schema::dropIfExists('wip_endpoints');
        Schema::dropIfExists('wip_settings');
        Schema::dropIfExists('wip_users');
        Schema::dropIfExists('wip_generate');
    }
};