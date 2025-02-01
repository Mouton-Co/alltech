<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

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
        'type',
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

    /**
     * Get pill text for meeting displayed on the calendar.
     * @param string $format
     * @return string
     */
    public function getPillText($format = 'title'): string
    {
        switch ($format) {
            case 'contact':
                return $this->contact->name ?? 'N/A';
                break;
            case 'company':
                return $this->company()->name ?? 'N/A';
                break;
            default:
                return $this->title;
                break;
        }
    }

    /**
     * Generate a list of items to be displayed in the PDF for each meeting.
     *
     * @param Request $request
     * @return array
     */
    public function getPdfList(Request $request): array
    {
        $lookup = $request->get('lookup', []);

        $list = [];
        foreach ($lookup as $value) {
            if ($value == 'contact') {
                $list[] = $this->contact->name ?? $this->contact->email ?? '';
            } elseif ($value == 'company') {
                $list[] = $this->company()->name ?? 'N/A';
            } elseif ($value == 'start_time') {
                $list[] = date('H:i', strtotime($this->start_time));
            } else {
                $list[] = $this->$value;
            }
        }

        return $list;
    }
}
