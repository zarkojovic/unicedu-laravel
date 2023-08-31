<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory;

    protected $primaryKey = 'page_id';

    protected $fillable = [
        'route', 'title', 'icon'
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FieldCategory::class, 'field_category_page');
    }

    public function role(): BelongsTo
    {
        return $this->BelongsTo(Role::class, 'role_id');
    }

}
