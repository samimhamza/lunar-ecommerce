<?php

namespace Lunar\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lunar\Base\BaseModel;
use Lunar\Base\Traits\HasMacros;
use Lunar\Database\Factories\CollectionGroupFactory;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * @property int $id
 * @property string $name
 * @property string $handle
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class CollectionGroup extends BaseModel implements Contracts\CollectionGroup
{
    use BelongsToTenant;
    use HasFactory;
    use HasMacros;

    protected $guarded = [];

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return CollectionGroupFactory::new();
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::modelClass());
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
