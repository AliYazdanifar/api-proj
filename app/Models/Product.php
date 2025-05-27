<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function teams(): MorphToMany
    {
        return $this->morphedByMany(Team::class, 'productable')
            ->withTimestamps();
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'productable')
            ->withTimestamps();
    }
}
