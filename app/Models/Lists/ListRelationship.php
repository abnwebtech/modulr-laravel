<?php

namespace App\Models\Lists;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListRelationship extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title'
    ];
}
