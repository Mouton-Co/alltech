<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function getFormattedFilterUsedAttribute(): string
    {
        $filterUsed = json_decode($this->filter_used, true);
        $filterUsedString = '';
        foreach ($filterUsed as $key => $value) {
            if($key == 'report_id'){
                continue;
            }
            $value = $this->getKeyRealValue($key, $value);
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $filterUsedString .= Str::ucfirst(Str::replace("_"," ",$key)).': '.($value??'n/a').'<br>';
        }
        return $filterUsedString;
    }

    protected function getKeyRealValue($key, $value){
        $return = $value;
        if($key == 'users'){
            $userNames = User::whereIn('id', $value)->get()->pluck('name')->toArray();
            $return = implode(', ', $userNames);
        }elseif ($key == 'company_types'){
            $companyTypeNames = CompanyType::whereIn('id', $value)->get()->pluck('name')->toArray();
            $return = implode(', ', $companyTypeNames);
        }elseif ($key == 'companies'){
            $companyNames = Company::whereIn('id', $value)->get()->pluck('name')->toArray();
            $return = implode(', ', $companyNames);
        }elseif ($key == 'contacts'){
            $contactNames = Contact::whereIn('id', $value)->get()->pluck('name')->toArray();
            $return = implode(', ', $contactNames);
        }
        return $return;
    }
}
