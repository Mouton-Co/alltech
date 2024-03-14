<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'date',
        'start_time',
        'end_time',
        'location',
        'report',
        'contact_id',
        'company_id',
        'company_type_id',
        'user_id',
        'cancelled_at',
        'cancelled_reason',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get meeting's contact.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get meeting's company
     */
    public function company()
    {
        return $this->contact->company;
    }

    /**
     * Get meeting's company type
     */
    public function companyType()
    {
        return $this->contact->company->companyType;
    }

    /**
     * Get meeting's user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
