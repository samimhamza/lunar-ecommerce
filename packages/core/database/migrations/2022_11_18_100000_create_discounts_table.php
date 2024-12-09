<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix.'discounts', function (Blueprint $table) {
            $table->id();
            $table->string('handle')->nullable();
            $table->string('name');
            $table->string('coupon')->nullable();
            $table->text('description')->nullable();
            $table->integer('type')->index();
            $table->integer('status')->index();
            $table->integer('uses')->default(0);
            $table->integer('max_uses')->nullable();
            $table->integer('priority')->default(1);
            $table->integer('stop')->default(0);
            $table->decimal('reduction')->nullable();
            $table->string('reduction_type')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['handle', 'tenant_id']);
            $table->unique(['coupon', 'tenant_id']);
            $table->timestamps();
            $table->json('data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix.'discounts');
    }
};
