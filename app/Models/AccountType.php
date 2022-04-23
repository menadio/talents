<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountType extends Model
{
    use HasFactory;

    protected $fillable  = ['type'];

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value)
        );
    }

    public function users()
    {
        return  $this->hasMany(User::class);
    }
}
