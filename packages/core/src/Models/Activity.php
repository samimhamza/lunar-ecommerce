<?php

namespace Lunar\Models;

use Spatie\Activitylog\Models\Activity as ModelsActivity;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;


class Activity extends ModelsActivity
{
    use BelongsToPrimaryModel;

    public function getRelationshipToPrimaryModel(): string
    {
        return 'subject';
    }
}
