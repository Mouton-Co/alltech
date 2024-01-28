<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmailCron extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'hour',
        'to',
        'subject',
        'filter',
    ];

    /*
    |--------------------------------------------------------------------------
    | GET ATTRIBUTES
    |--------------------------------------------------------------------------
    */
    public function getFormattedFilterAttribute(): string
    {
        $filterUsed = json_decode($this->filter, true);
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

    /*
    |--------------------------------------------------------------------------
    | PROTECTED FUNCTIONS
    |--------------------------------------------------------------------------
    */
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
