<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The blogs that belong to the category.
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class);
    }
}
