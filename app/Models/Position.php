<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value)
        );
    }

    public function salary(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value)
        );
    }

    public function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value)
        );
    }

    public function open(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => boolval($value)
        );
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->toDateTimeString()
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->toDateTimeString()
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

}
