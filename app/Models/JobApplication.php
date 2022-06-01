<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['position_id', 'user_id', 'status_id'];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
