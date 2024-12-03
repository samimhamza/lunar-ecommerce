<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix . 'languages', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // ->unique();
            $table->string('name');
            $table->boolean('default')->default(false)->index();
            $table->timestamps();
            $table->foreignUuid('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('seller_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['code', 'tenant_id', 'seller_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'languages');
    }
};
