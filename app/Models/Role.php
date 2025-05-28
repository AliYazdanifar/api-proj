<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission')
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'team_user','role_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class,'team_user','role_id');
    }

    public function hasPermissionTo(...$permissions): bool
    {
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }
}
