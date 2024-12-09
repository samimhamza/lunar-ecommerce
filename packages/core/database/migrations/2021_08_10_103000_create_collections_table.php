<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lunar\Base\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create($this->prefix.'collections', function (Blueprint $table) {
            $table->id();
            $table->string('collection_group_id');
            $table->nestedSet();
            $table->string('type')->default('static')->index();
            $table->boolean('default')->default(false)->index();
            $table->json('attribute_data');
            $table->string('sort')->default('custom')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('tenant_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->prefix.'collections');
    }
};
