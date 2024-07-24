<?php

namespace Lunar\Admin\Models;

use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role as ModelsRole;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Spatie\Permission\Guard;
use Spatie\Permission\PermissionRegistrar;

class Role extends ModelsRole
{
    use BelongsToTenant;

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);
        $attributes['tenant_id'] = $attributes['tenant_id'] ?? null;

        $params = ['name' => $attributes['name'], 'guard_name' => $attributes['guard_name'], 'tenant_id' => $attributes['tenant_id']];
        if (app(PermissionRegistrar::class)->teams) {
            $teamsKey = app(PermissionRegistrar::class)->teamsKey;

            if (array_key_exists($teamsKey, $attributes)) {
                $params[$teamsKey] = $attributes[$teamsKey];
            } else {
                $attributes[$teamsKey] = getPermissionsTeamId();
            }
        }
        if (static::findByParam($params)) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }
}
