<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix.'attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_type')->index();
            $table->foreignId('attribute_group_id')->constrained($this->prefix.'attribute_groups');
            $table->string('handle');
            $table->string('position')->default(1);
            $table->string('section')->nullable();
            $table->string('type')->index();
            $table->boolean('required')->default(false)->index();
            $table->boolean('searchable')->default(true)->index();
            $table->boolean('filterable')->default(true)->index();
            $table->json('name');
            $table->json('configuration');
            $table->json('system');
            $table->boolean('system');
            $table->timestamps();
            $table->foreignUuid('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix.'attributes');
    }
};
