<?php

namespace Lunar\Admin\Models;

use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Spatie\Permission\Guard;

class Permission extends ModelsPermission
{
    use BelongsToTenant;

    /**
     * @return PermissionContract|Permission
     *
     * @throws PermissionAlreadyExists
     */
    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? Guard::getDefaultName(static::class);
        $attributes['tenant_id'] = $attributes['tenant_id'] ?? null;

        $permission = static::getPermission(['name' => $attributes['name'], 'guard_name' => $attributes['guard_name'], 'tenant_id' => $attributes['tenant_id']]);

        if ($permission) {
            throw PermissionAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }
}
