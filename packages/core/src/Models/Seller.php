<?php

namespace Lunar\Models;

use Lunar\Enums\SellerStatus;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable implements HasName
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'status',
        'username',
        'email',
        'password',
    ];

    protected static $statuses = ['pending', 'active', 'inactive'];

    public static function getStatuses(): array
    {
        return self::$statuses;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => SellerStatus::class,
        ];
    }


    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
