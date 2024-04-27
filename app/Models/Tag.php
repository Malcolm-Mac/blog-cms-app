<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The blogs that belong to the tag.
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class);
    }
}
