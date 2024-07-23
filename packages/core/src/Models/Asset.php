<?php

namespace Lunar\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Lunar\Base\BaseModel;
use Lunar\Base\Traits\HasMedia as TraitsHasMedia;
use Spatie\MediaLibrary\HasMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

/**
 * @property int $id
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class Asset extends BaseModel implements HasMedia
{
    use TraitsHasMedia;

    use BelongsToPrimaryModel;

    public function getRelationshipToPrimaryModel(): string
    {
        return 'file';
    }

    /**
     * Define which attributes should be
     * protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the associated file.
     */
    public function file(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }
}
