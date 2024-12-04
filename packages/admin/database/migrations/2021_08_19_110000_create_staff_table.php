<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix.'staff', function (Blueprint $table) {
            $table->id();
            $table->boolean('admin')->default(false)->index();
            $table->string('firstname')->index();
            $table->string('lastname')->index();
            $table->string('email'); // ->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('seller_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['email', 'tenant_id', 'seller_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix.'staff');
    }
};
