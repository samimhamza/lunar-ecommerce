<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix . 'channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('handle'); //->unique();
            $table->boolean('default')->default(false)->index();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('seller_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['handle', 'tenant_id', 'seller_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'channels');
    }
};
