<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    public const REPEAT_FREQUENCY = [
        self::REPEAT_FREQUENCY_DAILY => 'Daily',
        self::REPEAT_FREQUENCY_WEEKLY => 'Weekly',
        self::REPEAT_FREQUENCY_MONTHLY => 'Monthly',
        self::REPEAT_FREQUENCY_YEARLY => 'Yearly',
    ];

    public const REPEAT_FREQUENCY_DAILY = 'daily';

    public const REPEAT_FREQUENCY_WEEKLY = 'weekly';

    public const REPEAT_FREQUENCY_MONTHLY = 'monthly';

    public const REPEAT_FREQUENCY_YEARLY = 'yearly';

    /**
     * The user who created the filter
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
