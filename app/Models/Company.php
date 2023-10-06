<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'coordinates',
        'company_type_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get company's type
     */
    public function companyType(): BelongsTo
    {
        return $this->belongsTo(CompanyType::class);
    }

    /**
     * Get company's contacts
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
